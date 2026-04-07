<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PromoController extends Controller
{
    /**
     * Menampilkan daftar promo untuk dikelola admin.
     */
    public function index(): View
    {
        $promos = Promo::latest()->paginate(10);

        return view('admin.promos.index', compact('promos'));
    }

    /**
     * Menampilkan form tambah promo baru.
     */
    public function create(): View
    {
        return view('admin.promos.create');
    }

    /**
     * Menyimpan promo baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'discount' => ['nullable', 'integer', 'min:1'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('promos', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        Promo::create($validated);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit data promo.
     */
    public function edit(Promo $promo): View
    {
        return view('admin.promos.edit', compact('promo'));
    }

    /**
     * Memperbarui data promo yang dipilih.
     */
    public function update(Request $request, Promo $promo): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'discount' => ['nullable', 'integer', 'min:1'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($promo->image && Storage::disk('public')->exists($promo->image)) {
                Storage::disk('public')->delete($promo->image);
            }

            $validated['image'] = $request->file('image')->store('promos', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $promo->update($validated);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil diperbarui.');
    }

    /**
     * Menghapus promo dari database.
     */
    public function destroy(Promo $promo): RedirectResponse
    {
        if ($promo->image && Storage::disk('public')->exists($promo->image)) {
            Storage::disk('public')->delete($promo->image);
        }

        $promo->delete();

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo berhasil dihapus.');
    }
}
