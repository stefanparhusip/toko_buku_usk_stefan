<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Redirect category click to the book list filtered by category id.
     */
    public function books(Request $request, Category $category): RedirectResponse
    {
        return redirect()->route('books.index', array_filter([
            'category' => $category->id,
            'search' => trim((string) $request->query('search', '')),
            'author' => trim((string) $request->query('author', '')),
        ], static fn ($value) => $value !== ''));
    }
}
