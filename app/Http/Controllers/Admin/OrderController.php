<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders for admin monitoring.
     */
    public function index(): View
    {
        $orders = Order::with(['user', 'orderDetails.book'])
            ->latest()
            ->paginate(12);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display detail information for a specific order.
     */
    public function show(Order $order): View
    {
        $order->load(['user', 'orderDetails.book']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status for admin order management.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,processing,completed'],
        ]);

        $currentStatus = $this->normalizeStatus($order->status);
        $targetStatus = $validated['status'];

        if ($currentStatus === Order::STATUS_COMPLETED) {
            return redirect()->back()->with('error', 'Status pesanan tidak dapat diubah kembali');
        }

        $allowedNextStatuses = $this->allowedNextStatuses($currentStatus, (string) $order->payment_method);

        if (! in_array($targetStatus, $allowedNextStatuses, true)) {
            return redirect()->back()->with('error', 'Status pesanan tidak dapat diubah kembali');
        }

        $order->update([
            'status' => $targetStatus,
        ]);

        return redirect()->back()->with('success', 'Status order berhasil diperbarui.');
    }

    /**
     * Normalize legacy statuses into supported one-way flow statuses.
     */
    private function normalizeStatus(string $status): string
    {
        return match ($status) {
            'sukses' => Order::STATUS_COMPLETED,
            'menunggu verifikasi' => Order::STATUS_PENDING,
            default => $status,
        };
    }

    /**
     * Determine the only allowed next status in irreversible flow.
     */
    private function allowedNextStatuses(string $currentStatus, string $paymentMethod): array
    {
        return match ($currentStatus) {
            Order::STATUS_PENDING => $paymentMethod === Order::PAYMENT_COD
                ? [Order::STATUS_PROCESSING, Order::STATUS_COMPLETED]
                : [Order::STATUS_PROCESSING],
            Order::STATUS_PROCESSING => [Order::STATUS_COMPLETED],
            default => [],
        };
    }
}
