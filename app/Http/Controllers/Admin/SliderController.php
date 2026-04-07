<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SliderController extends Controller
{
    /**
     * Display a listing of sliders.
     */
    public function index(): View
    {
        $sliders = Slider::latest()->paginate(10);

        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new slider.
     */
    public function create(): View
    {
        return view('admin.sliders.create');
    }

    /**
     * Store a newly created slider in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'price' => ['nullable', 'string', 'max:100'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['image'] = $request->file('image')->store('sliders', 'public');
        $validated['is_active'] = $request->boolean('is_active');

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified slider.
     */
    public function edit(Slider $slider): View
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified slider in storage.
     */
    public function update(Request $request, Slider $slider): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'price' => ['nullable', 'string', 'max:100'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }

            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil diperbarui.');
    }

    /**
     * Remove the specified slider from storage.
     */
    public function destroy(Slider $slider): RedirectResponse
    {
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider berhasil dihapus.');
    }
}
