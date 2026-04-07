<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Names that should not be used as main book categories.
     *
     * @var array<int, string>
     */
    private array $blockedCategoryNames = [
        'school kit',
        'best seller',
        'kids',
    ];

    /**
     * Display a listing of categories.
     */
    public function index(): View
    {
        $categories = Category::latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (in_array(strtolower(trim((string) $value)), $this->blockedCategoryNames, true)) {
                        $fail('Kategori tersebut tidak relevan untuk kategori buku utama.');
                    }
                },
            ],
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (in_array(strtolower(trim((string) $value)), $this->blockedCategoryNames, true)) {
                        $fail('Kategori tersebut tidak relevan untuk kategori buku utama.');
                    }
                },
            ],
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category berhasil diperbarui.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        try {
            $category->delete();

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Category tidak dapat dihapus.');
        }
    }
}
