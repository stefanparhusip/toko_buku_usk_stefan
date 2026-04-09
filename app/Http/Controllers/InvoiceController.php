<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Display invoice detail for the given order.
     */
    public function show(int $order_id): View
    {
        $order = $this->getAuthorizedOrder($order_id);

        return view('invoice.show', compact('order'));
    }

    /**
     * Download invoice as PDF.
     */
    public function download(int $order_id)
    {
        $order = $this->getAuthorizedOrder($order_id);

        $filename = 'invoice-' . ($order->order_code ?: $order->id) . '.pdf';

        return Pdf::loadView('invoice.pdf', compact('order'))
            ->setPaper('a4', 'portrait')
            ->download($filename);
    }

    /**
     * Load order and enforce role-based invoice access.
     */
    private function getAuthorizedOrder(int $order_id): Order
    {
        $order = Order::with(['user', 'orderDetails.book'])->findOrFail($order_id);

        if (auth()->user()?->role !== 'admin' && $order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat invoice ini.');
        }

        return $order;
    }
}
