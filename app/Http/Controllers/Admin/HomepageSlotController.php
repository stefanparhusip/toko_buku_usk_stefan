<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\HomepageSlot;
use App\Models\HomepageSlotItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HomepageSlotController extends Controller
{
    private const MIN_STATIC_SLOT = 2;
    private const MAX_STATIC_SLOT = 10;

    /**
     * Display homepage slots with visual preview.
     */
    public function index(): View|RedirectResponse
    {
        if (! Schema::hasTable('homepage_slots')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Tabel homepage_slots belum tersedia. Jalankan: php artisan migrate');
        }

        if (! Schema::hasColumn('homepage_slots', 'slot_number') || ! Schema::hasColumn('homepage_slots', 'order_number')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Kolom baru Homepage Slot belum tersedia. Jalankan: php artisan migrate');
        }

        $this->ensureDefaultSlots();

        $slotOneItems = HomepageSlot::with('book')
            ->where('slot_number', 1)
            ->orderBy('order_number')
            ->orderBy('id')
            ->get();

        $staticSlots = HomepageSlot::with('book')
            ->whereIn('slot_number', range(self::MIN_STATIC_SLOT, self::MAX_STATIC_SLOT))
            ->orderBy('slot_number')
            ->get();

        $heroPreview = $slotOneItems->first();
        $slots = $slotOneItems
            ->concat($staticSlots)
            ->sortBy([
                ['slot_number', 'asc'],
                ['order_number', 'asc'],
                ['id', 'asc'],
            ])
            ->values();

        $slotsByPosition = $staticSlots->keyBy('slot_number');
        if ($heroPreview) {
            $slotsByPosition->put(1, $heroPreview);
        }

        return view('admin.homepage-slots.index', [
            'slotOneItems' => $slotOneItems,
            'heroPreview' => $heroPreview,
            'staticSlots' => $staticSlots,
            'slots' => $slots,
            'slotsByPosition' => $slotsByPosition,
        ]);
    }

    /**
     * Store a new slider item for slot 1.
     */
    public function storeSlotOne(Request $request): RedirectResponse
    {
        $validated = $this->validateSlotPayload($request);

        $slot = new HomepageSlot([
            'position' => $this->nextAvailablePosition(),
            'slot_number' => 1,
            'type' => 'hero',
            'name' => $validated['title'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'] ?? 'Lihat Detail',
            'book_id' => $validated['book_id'] ?? null,
            'link' => $validated['link'] ?? null,
            'order_number' => (int) $validated['order_number'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->syncImageFields($request, $slot, $validated);
        $slot->save();

        return redirect()->route('admin.homepage-slots.index')
            ->with('success', 'Item slider Slot 1 berhasil ditambahkan.');
    }

    /**
     * Show edit form for one slot.
     */
    public function edit(HomepageSlot $homepageSlot): View
    {
        $books = Book::orderBy('title')->get(['id', 'title']);

        return view('admin.homepage-slots.edit', [
            'slot' => $homepageSlot->load(['book', 'items']),
            'books' => $books,
        ]);
    }

    /**
     * Store a new content item under the selected slot.
     */
    public function storeItem(Request $request, HomepageSlot $homepageSlot): RedirectResponse
    {
        $validated = $this->validateItemPayload($request, true);

        $item = new HomepageSlotItem([
            'slot_id' => $homepageSlot->id,
            'slot_position' => (int) ($homepageSlot->slot_number ?? $homepageSlot->position ?? 1),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'link' => $validated['link'] ?? null,
            'order_number' => (int) $validated['order_number'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->syncItemImage($request, $item);
        $item->save();

        return redirect()->route('admin.homepage-slots.edit', $homepageSlot)
            ->with('success', 'Item slot berhasil ditambahkan.');
    }

    /**
     * Update one content item under the selected slot.
     */
    public function updateItem(Request $request, HomepageSlot $homepageSlot, HomepageSlotItem $item): RedirectResponse
    {
        if ((int) $item->slot_id !== (int) $homepageSlot->id) {
            abort(404);
        }

        $validated = $this->validateItemPayload($request, false);

        $payload = [
            'slot_position' => (int) ($homepageSlot->slot_number ?? $homepageSlot->position ?? 1),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'button_text' => $validated['button_text'] ?? null,
            'link' => $validated['link'] ?? null,
            'order_number' => (int) $validated['order_number'],
            'is_active' => $request->boolean('is_active'),
        ];

        $this->syncItemImage($request, $item, $payload);

        $item->update($payload);

        return redirect()->route('admin.homepage-slots.edit', $homepageSlot)
            ->with('success', 'Item slot berhasil diperbarui.');
    }

    /**
     * Delete one content item under the selected slot.
     */
    public function destroyItem(HomepageSlot $homepageSlot, HomepageSlotItem $item): RedirectResponse
    {
        if ((int) $item->slot_id !== (int) $homepageSlot->id) {
            abort(404);
        }

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('admin.homepage-slots.edit', $homepageSlot)
            ->with('success', 'Item slot berhasil dihapus.');
    }

    /**
     * Reorder slot items based on drag-and-drop position.
     */
    public function reorderItems(Request $request, HomepageSlot $homepageSlot): RedirectResponse
    {
        $validated = $request->validate([
            'item_ids' => ['required', 'array', 'min:1'],
            'item_ids.*' => ['required', 'integer'],
        ]);

        $itemIds = collect($validated['item_ids'])
            ->map(fn ($id) => (int) $id)
            ->values();

        $validIds = HomepageSlotItem::where('slot_id', $homepageSlot->id)
            ->whereIn('id', $itemIds)
            ->pluck('id')
            ->map(fn ($id) => (int) $id);

        DB::transaction(function () use ($itemIds, $validIds) {
            $order = 1;
            foreach ($itemIds as $itemId) {
                if (! $validIds->contains($itemId)) {
                    continue;
                }

                HomepageSlotItem::where('id', $itemId)->update(['order_number' => $order]);
                $order++;
            }
        });

        return redirect()->route('admin.homepage-slots.edit', $homepageSlot)
            ->with('success', 'Urutan slide berhasil diperbarui.');
    }

    /**
     * Update slot content.
     */
    public function update(Request $request, HomepageSlot $homepageSlot): RedirectResponse
    {
        $validated = $this->validateSlotPayload($request);

        // Keep slot internal label aligned with title to avoid duplicate naming inputs.
        $validated['name'] = $validated['title'];

        if ((int) $homepageSlot->slot_number !== 1) {
            $validated['order_number'] = 1;
            $validated['button_text'] = $validated['button_text'] ?? 'Buka';
        }

        if ($homepageSlot->type !== 'book') {
            $validated['book_id'] = null;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $this->syncImageFields($request, $homepageSlot, $validated);

        $homepageSlot->update($validated);

        return redirect()->route('admin.homepage-slots.index')
            ->with('success', 'Slot homepage berhasil diperbarui.');
    }

    /**
     * Delete one slot item. Multi-item deletion is only allowed for slot 1.
     */
    public function destroy(HomepageSlot $homepageSlot): RedirectResponse
    {
        if ((int) $homepageSlot->slot_number !== 1) {
            return redirect()->route('admin.homepage-slots.index')
                ->with('error', 'Slot statis tidak dapat dihapus.');
        }

        if ($homepageSlot->image && Storage::disk('public')->exists($homepageSlot->image)) {
            Storage::disk('public')->delete($homepageSlot->image);
        }

        $homepageSlot->delete();

        return redirect()->route('admin.homepage-slots.index')
            ->with('success', 'Item slider Slot 1 berhasil dihapus.');
    }

    /**
     * Ensure slot positions 1-10 always exist.
     */
    private function ensureDefaultSlots(): void
    {
        if (! Schema::hasTable('homepage_slots')) {
            return;
        }

        HomepageSlot::query()
            ->whereNull('slot_number')
            ->whereNotNull('position')
            ->update([
                'slot_number' => DB::raw('position'),
            ]);

        if (! HomepageSlot::where('slot_number', 1)->exists()) {
            HomepageSlot::create([
                'position' => 1,
                'slot_number' => 1,
                'order_number' => 1,
                'name' => 'Slider Hero 1',
                'title' => 'Slider Hero 1',
                'description' => 'Isi slider hero pertama untuk homepage.',
                'button_text' => 'Lihat Detail',
                'image' => null,
                'image_url' => null,
                'book_id' => null,
                'link' => null,
                'type' => 'hero',
                'is_active' => true,
            ]);
        }

        foreach (range(self::MIN_STATIC_SLOT, self::MAX_STATIC_SLOT) as $position) {
            $slot = HomepageSlot::firstOrCreate(
                ['slot_number' => $position],
                [
                    'position' => $position,
                    'slot_number' => $position,
                    'order_number' => 1,
                    'name' => 'Slot '.$position,
                    'title' => 'Slot '.$position,
                    'description' => null,
                    'image' => null,
                    'image_url' => null,
                    'button_text' => 'Buka',
                    'book_id' => null,
                    'link' => null,
                    'type' => $this->resolveTypeByPosition($position),
                    'is_active' => true,
                ]
            );

            if (blank($slot->name)) {
                $slot->update([
                    'name' => $slot->title ?: 'Slot '.$position,
                ]);
            }
        }
    }

    /**
     * Validate input payload for slot create/update.
     */
    private function validateSlotPayload(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:60'],
            'order_number' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'book_id' => ['nullable', Rule::exists('books', 'id')],
            'link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Validate payload for slot item create/update.
     */
    private function validateItemPayload(Request $request, bool $isCreate): array
    {
        $imageRules = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'];
        $imageUrlRules = ['nullable', 'url', 'max:2048'];

        if ($isCreate) {
            $imageRules[] = 'required_without:image_url';
            $imageUrlRules[] = 'required_without:image';
        }

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => $imageRules,
            'image_url' => $imageUrlRules,
            'button_text' => ['nullable', 'string', 'max:60'],
            'link' => ['nullable', 'string', 'max:255'],
            'order_number' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    /**
     * Sync slot item image upload and payload.
     */
    private function syncItemImage(Request $request, HomepageSlotItem $item, array &$payload = []): void
    {
        $payload['image_url'] = filled($request->input('image_url'))
            ? trim((string) $request->input('image_url'))
            : null;

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $payload['image'] = $request->file('image')->store('homepage-slot-items', 'public');
            $payload['image_url'] = null;

            return;
        }

        if (! empty($payload['image_url']) && $item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
            $payload['image'] = null;
        }
    }

    /**
     * Keep image fields consistent when upload/url changes.
     */
    private function syncImageFields(Request $request, HomepageSlot $slot, array &$validated): void
    {
        $validated['image_url'] = filled($request->input('image_url'))
            ? trim((string) $request->input('image_url'))
            : null;

        if ($request->hasFile('image')) {
            if ($slot->image && Storage::disk('public')->exists($slot->image)) {
                Storage::disk('public')->delete($slot->image);
            }

            $validated['image'] = $request->file('image')->store('homepage-slots', 'public');
            $validated['image_url'] = null;
        } elseif (! empty($validated['image_url'])) {
            if ($slot->image && Storage::disk('public')->exists($slot->image)) {
                Storage::disk('public')->delete($slot->image);
            }

            $validated['image'] = null;
        } else {
            unset($validated['image']);
        }

        $validated['button_text'] = filled($validated['button_text'] ?? null)
            ? Str::limit(trim((string) $validated['button_text']), 60, '')
            : null;
    }

    /**
     * Generate unique position value to satisfy legacy uniqueness constraint.
     */
    private function nextAvailablePosition(): int
    {
        return ((int) HomepageSlot::max('position')) + 1;
    }

    /**
     * Resolve slot type based on fixed homepage positions.
     */
    private function resolveTypeByPosition(int $position): string
    {
        if ($position === 1) {
            return 'hero';
        }

        if (in_array($position, [2, 3], true)) {
            return 'banner';
        }

        return 'book';
    }
}
