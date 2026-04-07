<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PromoController as AdminPromoController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\HomepageSlotController as AdminHomepageSlotController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController as UserCategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ProfileController;
use App\Models\Book;
use App\Models\Category;
use App\Models\HomepageSlot;
use App\Models\Promo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $categories = Schema::hasTable('categories')
        ? Category::orderBy('name')->get(['id', 'name'])
        : collect();

    if (Schema::hasTable('books')) {
        $latestBooks = Book::with('category')
            ->where('is_new', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        $recommendedBooks = Book::with('category')
            ->where('is_recommended', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(6)
            ->get();

        $bestSellerBooks = Book::with('category')
            ->where('is_featured', true)
            ->where('stock', '>', 0)
            ->latest()
            ->take(6)
            ->get();
    } else {
        $latestBooks = collect();
        $bestSellerBooks = collect();
        $recommendedBooks = collect();
    }

    $activePromos = Schema::hasTable('promos')
        ? Promo::activeAndValid()->latest()->take(3)->get()
        : collect();

    $homepageSlots = Schema::hasTable('homepage_slots')
        ? HomepageSlot::with('book')
            ->whereIn('position', range(1, 10))
            ->orderBy('position')
            ->get()
            ->keyBy('position')
        : collect();

    return view('landing', compact('categories', 'latestBooks', 'bestSellerBooks', 'recommendedBooks', 'activePromos', 'homepageSlots'));
})->name('landing');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
Route::get('/search', [BookController::class, 'search'])->name('search');
Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');
Route::get('/categories/{category}/books', [UserCategoryController::class, 'books'])
    ->name('categories.books');

Route::view('/about', 'user.pages.about')->name('about');
Route::view('/contact', 'user.pages.contact')->name('contact');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('books', AdminBookController::class)->except(['show']);
    Route::resource('promos', AdminPromoController::class)->except(['show']);
    Route::resource('sliders', AdminSliderController::class)->except(['show']);
    Route::get('/homepage-slots', [AdminHomepageSlotController::class, 'index'])->name('homepage-slots.index');
    Route::get('/homepage-slots/{homepageSlot}/edit', [AdminHomepageSlotController::class, 'edit'])->name('homepage-slots.edit');
    Route::put('/homepage-slots/{homepageSlot}', [AdminHomepageSlotController::class, 'update'])->name('homepage-slots.update');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::patch('/contacts/{contact}/reply', [AdminContactController::class, 'updateReply'])->name('contacts.reply');
});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout/process', [OrderController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
    Route::patch('/orders/{order}/confirm-transfer', [OrderController::class, 'confirmTransfer'])->name('orders.confirm-transfer');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/my-messages', [ContactController::class, 'index'])->name('contacts.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
