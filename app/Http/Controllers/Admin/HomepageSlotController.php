<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\HomepageSlot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HomepageSlotController extends Controller
{
    private const MAX_SLOT_POSITION = 10;

    /**
     * Display homepage slots with visual preview.
     */
    public function index(): View|RedirectResponse
    {
        if (! Schema::hasTable('homepage_slots')) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Tabel homepage_slots belum tersedia. Jalankan: php artisan migrate');
        }

        $this->ensureDefaultSlots();

        $slots = HomepageSlot::with('book')
            ->orderBy('position')
            ->get();

        return view('admin.homepage-slots.index', [
            'slots' => $slots,
            'slotsByPosition' => $slots->keyBy('position'),
        ]);
    }

    /**
     * Show edit form for one slot.
     */
    public function edit(HomepageSlot $homepageSlot): View
    {
        $books = Book::orderBy('title')->get(['id', 'title']);

        return view('admin.homepage-slots.edit', [
            'slot' => $homepageSlot->load('book'),
            'books' => $books,
        ]);
    }

    /**
     * Update slot content.
     */
    public function update(Request $request, HomepageSlot $homepageSlot): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'book_id' => ['nullable', Rule::exists('books', 'id')],
            'link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        // Keep slot internal label aligned with title to avoid duplicate naming inputs.
        $validated['name'] = $validated['title'];

        if ($homepageSlot->type !== 'book') {
            $validated['book_id'] = null;
        }

        $validated['image_url'] = filled($request->input('image_url'))
            ? trim((string) $request->input('image_url'))
            : null;

        if ($request->hasFile('image')) {
            if ($homepageSlot->image && Storage::disk('public')->exists($homepageSlot->image)) {
                Storage::disk('public')->delete($homepageSlot->image);
            }

            $validated['image'] = $request->file('image')->store('homepage-slots', 'public');
            $validated['image_url'] = null;
        } elseif (! empty($validated['image_url'])) {
            if ($homepageSlot->image && Storage::disk('public')->exists($homepageSlot->image)) {
                Storage::disk('public')->delete($homepageSlot->image);
            }

            $validated['image'] = null;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $homepageSlot->update($validated);

        return redirect()->route('admin.homepage-slots.index')
            ->with('success', 'Slot homepage berhasil diperbarui.');
    }

    /**
     * Ensure slot positions 1-10 always exist.
     */
    private function ensureDefaultSlots(): void
    {
        if (! Schema::hasTable('homepage_slots')) {
            return;
        }

        foreach (range(1, self::MAX_SLOT_POSITION) as $position) {
            $slot = HomepageSlot::firstOrCreate(
                ['position' => $position],
                [
                    'name' => 'Slot '.$position,
                    'title' => 'Slot '.$position,
                    'description' => null,
                    'image' => null,
                    'image_url' => null,
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
