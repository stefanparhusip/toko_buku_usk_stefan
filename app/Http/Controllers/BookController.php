<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\HomepageSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a paginated list of books with optional search by title or category.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', $request->query('q', '')));
        $categoryId = (int) $request->query('category', 0);
        $selectedAuthor = trim((string) $request->query('author', ''));

        $books = Book::with('category')
            ->when($categoryId > 0, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($selectedAuthor !== '', function ($query) use ($selectedAuthor) {
                $query->where('author', $selectedAuthor);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%' . $search . '%')
                        ->orWhere('author', 'like', '%' . $search . '%')
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->paginate(8);

        $categories = Schema::hasTable('categories')
            ? Category::orderBy('name')->get(['id', 'name'])
            : collect();

        $authors = Book::query()
            ->whereNotNull('author')
            ->where('author', '!=', '')
            ->select('author')
            ->distinct()
            ->orderBy('author')
            ->pluck('author');

        $homepageSlots = Schema::hasTable('homepage_slots')
            ? HomepageSlot::whereIn('position', [1, 2, 3])
                ->where('is_active', true)
                ->orderBy('position')
                ->get()
                ->keyBy('position')
            : collect();

        return view('user.books.index', [
            'books' => $books,
            'search' => $search,
            'categories' => $categories,
            'authors' => $authors,
            'selectedCategory' => $categoryId,
            'selectedAuthor' => $selectedAuthor,
            'homepageSlots' => $homepageSlots,
        ]);
    }

    /**
     * Search endpoint from navbar that maps `q` parameter into book listing.
     */
    public function search(Request $request): View
    {
        $request->merge([
            'search' => trim((string) $request->query('q', $request->query('search', ''))),
        ]);

        return $this->index($request);
    }

    /**
     * Display the detail page of a single book.
     */
    public function show(Request $request, int $id): View
    {
        $book = Book::with('category')->findOrFail($id);
        // Default to full detail page when user opens /books/{id}.
        $focusDetail = $request->boolean('focus', true);

        $search = trim((string) $request->query('q', ''));
        $sort = (string) $request->query('sort', 'newest');
        $categoryId = (int) $request->query('category', 0);
        $inStockOnly = $request->boolean('in_stock');

        $relatedBooksQuery = Book::with('category')
            ->whereKeyNot($book->id)
            ->when($categoryId > 0, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($inStockOnly, function ($query) {
                $query->where('stock', '>', 0);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%' . $search . '%')
                        ->orWhere('author', 'like', '%' . $search . '%');
                });
            });

        if ($sort === 'price_low') {
            $relatedBooksQuery->orderBy('price');
        } elseif ($sort === 'price_high') {
            $relatedBooksQuery->orderByDesc('price');
        } else {
            $relatedBooksQuery->latest();
        }

        $relatedBooks = $relatedBooksQuery->paginate(8);

        $categories = Schema::hasTable('categories')
            ? Category::orderBy('name')->get(['id', 'name'])
            : collect();

        $homepageSlots = Schema::hasTable('homepage_slots')
            ? HomepageSlot::whereIn('position', [1, 2, 3])
                ->where('is_active', true)
                ->orderBy('position')
                ->get()
                ->keyBy('position')
            : collect();

        return view('user.books.show', [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
            'categories' => $categories,
            'selectedCategory' => $categoryId,
            'selectedSort' => $sort,
            'search' => $search,
            'inStockOnly' => $inStockOnly,
            'focusDetail' => $focusDetail,
            'homepageSlots' => $homepageSlots,
        ]);
    }
}
