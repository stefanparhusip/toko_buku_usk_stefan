<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index(): View
    {
        $books = Book::with('category')->latest()->paginate(10);

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:10'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'required_without:image_url'],
            'image_url' => ['nullable', 'url', 'max:2048', 'required_without:image'],
            'is_featured' => ['nullable', 'boolean'],
            'is_recommended' => ['nullable', 'boolean'],
            'is_new' => ['nullable', 'boolean'],
        ]);

        $validated['image_url'] = filled($request->input('image_url'))
            ? trim((string) $request->input('image_url'))
            : null;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('books', 'public');
            $validated['image_url'] = null;
        } else {
            $validated['image'] = null;
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_recommended'] = $request->boolean('is_recommended');
        $validated['is_new'] = $request->boolean('is_new');

        Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'year' => ['required', 'string', 'max:10'],
            'price' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'image_url' => ['nullable', 'url', 'max:2048'],
            'is_featured' => ['nullable', 'boolean'],
            'is_recommended' => ['nullable', 'boolean'],
            'is_new' => ['nullable', 'boolean'],
        ]);

        $validated['image_url'] = filled($request->input('image_url'))
            ? trim((string) $request->input('image_url'))
            : null;

        if ($request->hasFile('image')) {
            if ($book->image && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }

            $validated['image'] = $request->file('image')->store('books', 'public');
            $validated['image_url'] = null;
        } elseif (! empty($validated['image_url'])) {
            if ($book->image && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }

            $validated['image'] = null;
        } else {
            unset($validated['image_url']);
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_recommended'] = $request->boolean('is_recommended');
        $validated['is_new'] = $request->boolean('is_new');

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book berhasil diperbarui.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book): RedirectResponse
    {
        if ($book->image && Storage::disk('public')->exists($book->image)) {
            Storage::disk('public')->delete($book->image);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Book berhasil dihapus.');
    }
}
