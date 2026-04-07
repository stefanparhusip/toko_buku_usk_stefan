<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display all cart items that belong to the authenticated user.
     */
    public function index(): View
    {
        $cartItems = Cart::with('book')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $grandTotal = $cartItems->sum('total_price');

        return view('user.cart.index', compact('cartItems', 'grandTotal'));
    }

    /**
     * Add a book to cart or increase quantity if the item already exists.
     */
    public function addToCart(int $id): RedirectResponse
    {
        $book = Book::findOrFail($id);

        if ($book->stock < 1) {
            return redirect()->back()->with('error', 'Stok buku habis.');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->first();

        $newQuantity = $cart ? $cart->quantity + 1 : 1;

        if ($newQuantity > $book->stock) {
            return redirect()->back()->with('error', 'Quantity melebihi stok buku yang tersedia.');
        }

        if ($cart) {
            $cart->update([
                'quantity' => $newQuantity,
                'total_price' => $book->price * $newQuantity,
            ]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'quantity' => 1,
                'total_price' => $book->price,
            ]);
        }

        return redirect()->back()->with('success', 'Buku sudah ditambahkan ke keranjang.');
    }

    /**
     * Update quantity and total price for a specific cart item.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $cart = Cart::with('book')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        if ((int) $validated['quantity'] > $cart->book->stock) {
            return redirect()->route('cart.index')
                ->with('error', 'Quantity melebihi stok buku yang tersedia.');
        }

        $cart->update([
            'quantity' => (int) $validated['quantity'],
            'total_price' => $cart->book->price * (int) $validated['quantity'],
        ]);

        return redirect()->route('cart.index')->with('success', 'Cart berhasil diperbarui.');
    }

    /**
     * Remove a cart item that belongs to the authenticated user.
     */
    public function destroy(int $id): RedirectResponse
    {
        $cart = Cart::where('user_id', auth()->id())->findOrFail($id);

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item cart berhasil dihapus.');
    }
}
