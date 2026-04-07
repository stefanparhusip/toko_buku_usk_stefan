<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display checkout page using authenticated user cart items.
     */
    public function checkout(): View|RedirectResponse
    {
        $cartItems = Cart::with('book')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart kosong, tidak bisa checkout.');
        }

        $totalPayment = $cartItems->sum('total_price');

        return view('user.checkout.index', compact('cartItems', 'totalPayment'));
    }

    /**
     * Process checkout transaction: create order, order details, reduce stock, and clear cart.
     */
    public function processCheckout(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'nama_penerima' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
            'city' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'payment_method' => ['required', 'in:' . Order::PAYMENT_COD . ',' . Order::PAYMENT_BANK_TRANSFER],
        ]);

        $userId = auth()->id();

        $cartItems = Cart::with('book')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart kosong, tidak bisa checkout.');
        }

        $order = DB::transaction(function () use ($cartItems, $userId, $validated) {
            $totalPrice = (int) $cartItems->sum('total_price');

            $order = Order::create([
                'user_id' => $userId,
                'order_code' => $this->generateOrderCode(),
                'nama_penerima' => $validated['nama_penerima'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'total_price' => Schema::hasColumn('orders', 'total_price') ? $totalPrice : null,
                'total_payment' => $totalPrice,
                'status' => Order::STATUS_PENDING,
                'payment_method' => $validated['payment_method'],
                'resi' => null,
            ]);

            foreach ($cartItems as $item) {
                $book = $item->book()->lockForUpdate()->first();

                if (! $book || $book->stock < $item->quantity) {
                    throw new \RuntimeException('Stok buku tidak mencukupi untuk checkout.');
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'book_id' => $book->id,
                    'quantity' => $item->quantity,
                    'price' => $book->price,
                    'subtotal' => $book->price * $item->quantity,
                ]);

                $book->decrement('stock', $item->quantity);
            }

            Cart::where('user_id', $userId)->delete();

            return $order->load('orderDetails.book');
        });

        return view('user.checkout.success', compact('order'));
    }

    /**
     * Display all orders that belong to the authenticated user.
     */
    public function index(): View
    {
        $orders = Order::with('orderDetails.book')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    /**
     * Display purchase history for authenticated user.
     */
    public function history(): View
    {
        $orders = Order::with('orderDetails.book')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('user.orders.history', compact('orders'));
    }

    /**
     * Mark bank transfer order as submitted by user.
     */
    public function confirmTransfer(Order $order): RedirectResponse
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_method !== Order::PAYMENT_BANK_TRANSFER) {
            return redirect()->route('orders.index')->with('error', 'Order ini bukan pembayaran transfer.');
        }

        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->route('orders.index')->with('error', 'Order ini tidak dapat dikonfirmasi lagi.');
        }

        $order->update([
            'status' => Order::STATUS_WAITING_VERIFICATION,
        ]);

        return redirect()->route('orders.index')->with('success', 'Konfirmasi transfer berhasil dikirim.');
    }

    /**
     * Generate a unique order code using timestamp and random digits.
     */
    private function generateOrderCode(): string
    {
        do {
            $code = 'ORD-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }
}
