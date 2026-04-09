<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with(['user', 'orderDetails.book'])
            ->latest()
            ->paginate(12);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'orderDetails.book']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,processing,shipped,completed,cancelled'],
        ]);

        $currentStatus = $this->normalizeStatus($order->status);
        $targetStatus = $validated['status'];

        $order->status = $currentStatus;

        if ($currentStatus === Order::STATUS_CANCELLED) {
            return redirect()->back()->with('error', 'Order yang sudah dibatalkan tidak dapat diproses kembali.');
        }

        if ($currentStatus === Order::STATUS_COMPLETED) {
            return redirect()->back()->with('error', 'Status pesanan tidak dapat diubah kembali');
        }

        if ($currentStatus !== $targetStatus && ! $order->canTransitionTo($targetStatus)) {
            return redirect()->back()->with('error', 'Status pesanan tidak dapat diubah kembali');
        }

        DB::transaction(function () use ($order, $targetStatus): void {
            $payload = [
                'status' => $targetStatus,
            ];

            if ($targetStatus === Order::STATUS_PAID) {
                $payload['payment_status'] = Order::PAYMENT_STATUS_PAID;
            }

            $order->update($payload);
        });

        return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
    }

    public function confirmPayment(Order $order): RedirectResponse
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        if (! $order->isOfflinePayment()) {
            return redirect()->back()->with('error', 'Konfirmasi pembayaran hanya untuk metode Bayar Langsung.');
        }

        if ((string) $order->payment_status === Order::PAYMENT_STATUS_PAID) {
            return redirect()->back()->with('error', 'Pembayaran order ini sudah dikonfirmasi.');
        }

        DB::transaction(function () use ($order) {
            $order->refresh();

            if ((string) $order->payment_status === Order::PAYMENT_STATUS_PAID) {
                return;
            }

            if (in_array((string) $order->status, [Order::STATUS_CANCELLED, Order::STATUS_COMPLETED], true)) {
                return;
            }

            $receiptNumber = $this->generateOfflineReceiptNumber();

            $order->update([
                'payment_status' => Order::PAYMENT_STATUS_PAID,
                'receipt_number' => $receiptNumber,
                'status' => (string) $order->status === Order::STATUS_PENDING ? Order::STATUS_PAID : $order->status,
            ]);
        });

        return redirect()->back()->with('success', 'Pembayaran offline berhasil dikonfirmasi.');
    }

    public function cancel(Order $order): RedirectResponse
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $isCancelled = DB::transaction(function () use ($order) {
            $lockedOrder = Order::with('orderDetails')
                ->lockForUpdate()
                ->find($order->id);

            if (! $lockedOrder || ! in_array((string) $lockedOrder->status, [
                Order::STATUS_PENDING,
                Order::STATUS_PAID,
                Order::STATUS_PROCESSING,
            ], true)) {
                return false;
            }

            foreach ($lockedOrder->orderDetails as $detail) {
                Book::whereKey($detail->book_id)
                    ->lockForUpdate()
                    ->increment('stock', (int) $detail->quantity);
            }

            $lockedOrder->update([
                'status' => Order::STATUS_CANCELLED,
            ]);

            return true;
        });

        if (! $isCancelled) {
            return redirect()->back()->with('error', 'Order ini tidak dapat dibatalkan.');
        }

        return redirect()->back()->with('success', 'Pesanan telah dibatalkan oleh admin');
    }

    private function normalizeStatus(string $status): string
    {
        return match ($status) {
            'sukses' => Order::STATUS_COMPLETED,
            'menunggu verifikasi' => Order::STATUS_PAID,
            default => $status,
        };
    }

    private function generateOfflineReceiptNumber(): string
    {
        $dateSegment = now()->format('Ymd');
        $prefix = 'INV-OFF-' . $dateSegment . '-';

        $latestTodayReceipt = Order::query()
            ->where('receipt_number', 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderByDesc('receipt_number')
            ->value('receipt_number');

        $nextIncrement = 1;

        if (is_string($latestTodayReceipt) && str_starts_with($latestTodayReceipt, $prefix)) {
            $lastSequence = (int) substr($latestTodayReceipt, strlen($prefix));
            $nextIncrement = $lastSequence + 1;
        }

        return $prefix . str_pad((string) $nextIncrement, 3, '0', STR_PAD_LEFT);
    }
}
