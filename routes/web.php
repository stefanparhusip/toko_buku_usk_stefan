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
use App\Http\Controllers\Admin\ChatController as AdminChatController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController as UserCategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ProfileController;
use App\Models\Book;
use App\Models\Category;
use App\Models\HomepageSlot;
use App\Models\HomepageSlotItem;
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

    if (Schema::hasTable('homepage_slots')) {
        $hasSlotNumber = Schema::hasColumn('homepage_slots', 'slot_number');

        $slotOne = $hasSlotNumber
            ? HomepageSlot::where('slot_number', 1)->first()
            : HomepageSlot::where('position', 1)->first();

        if (Schema::hasTable('homepage_slot_items')) {
            if (Schema::hasColumn('homepage_slot_items', 'slot_position')) {
                $slotOneItems = HomepageSlotItem::where('slot_position', 1)
                    ->where('is_active', true)
                    ->orderBy('order_number')
                    ->orderBy('id')
                    ->get();
            } else {
                $slotOneItems = HomepageSlotItem::where('slot_id', $slotOne?->id ?? 1)
                    ->where('is_active', true)
                    ->orderBy('order_number')
                    ->orderBy('id')
                    ->get();
            }
        } else {
            $slotOneItems = collect();
        }

        // Keep the original Slot 1 row as primary slide and append dynamic items.
        $slotOneItems = collect()
            ->when($slotOne && $slotOne->is_active, fn ($collection) => $collection->push($slotOne))
            ->concat($slotOneItems)
            ->sortBy([
                ['order_number', 'asc'],
                ['id', 'asc'],
            ])
            ->values();

        $homepageSlots = ($hasSlotNumber
            ? HomepageSlot::with('book')->whereIn('slot_number', range(2, 10))->orderBy('slot_number')->get()->keyBy('slot_number')
            : HomepageSlot::with('book')->whereIn('position', range(2, 10))->orderBy('position')->get()->keyBy('position'));

        $homepageSlotsByNumber = $homepageSlots;
    } else {
        $slotOne = null;
        $slotOneItems = collect();
        $homepageSlotsByNumber = collect();
        $homepageSlots = collect();
    }

    return view('landing', compact('categories', 'latestBooks', 'bestSellerBooks', 'recommendedBooks', 'activePromos', 'slotOneItems', 'homepageSlotsByNumber', 'homepageSlots', 'slotOne'));
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
    Route::post('/homepage-slots/slot-1', [AdminHomepageSlotController::class, 'storeSlotOne'])->name('homepage-slots.slot-one.store');
    Route::get('/homepage-slots/{homepageSlot}/edit', [AdminHomepageSlotController::class, 'edit'])->name('homepage-slots.edit');
    Route::put('/homepage-slots/{homepageSlot}', [AdminHomepageSlotController::class, 'update'])->name('homepage-slots.update');
    Route::post('/homepage-slots/{homepageSlot}/items', [AdminHomepageSlotController::class, 'storeItem'])->name('homepage-slots.items.store');
    Route::patch('/homepage-slots/{homepageSlot}/items/reorder', [AdminHomepageSlotController::class, 'reorderItems'])->name('homepage-slots.items.reorder');
    Route::put('/homepage-slots/{homepageSlot}/items/{item}', [AdminHomepageSlotController::class, 'updateItem'])->name('homepage-slots.items.update');
    Route::delete('/homepage-slots/{homepageSlot}/items/{item}', [AdminHomepageSlotController::class, 'destroyItem'])->name('homepage-slots.items.destroy');
    Route::delete('/homepage-slots/{homepageSlot}', [AdminHomepageSlotController::class, 'destroy'])->name('homepage-slots.destroy');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('/orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('/orders/{order}/confirm-payment', [AdminOrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
    Route::resource('users', AdminUserController::class)->except(['destroy']);
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::patch('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->name('users.reset-password');
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::patch('/contacts/{contact}/reply', [AdminContactController::class, 'updateReply'])->name('contacts.reply');

    Route::get('/chat', [AdminChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [AdminChatController::class, 'index'])->name('chat.show');
    Route::post('/chat/{user}', [AdminChatController::class, 'store'])->name('chat.store');
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
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/invoice/{order_id}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/invoice/{order_id}/download', [InvoiceController::class, 'download'])->name('invoice.download');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::redirect('/chat-admin', '/chat');
    Route::post('/chat-admin', [ChatController::class, 'store']);
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/my-messages', [ContactController::class, 'index'])->name('contacts.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
