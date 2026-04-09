@extends('user.layouts.app', ['title' => 'Checkout Success'])

@php
    use App\Models\Order;
@endphp

@section('content')
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-5 text-center">
            <h2 class="section-title mb-2">Order Berhasil Dibuat</h2>
            <p class="text-muted mb-4">Terima kasih, pesanan Anda berhasil diproses.</p>

            <div class="mx-auto" style="max-width: 460px;">
                <div class="border rounded-3 p-3 mb-3 d-flex justify-content-between">
                    <span class="text-muted">Order Code</span>
                    <strong>{{ $order->order_code }}</strong>
                </div>
                <div class="border rounded-3 p-3 mb-3 d-flex justify-content-between">
                    <span class="text-muted">Status</span>
                    <strong class="text-uppercase">{{ $order->status }}</strong>
                </div>
                <div class="border rounded-3 p-3 mb-3 d-flex justify-content-between">
                    <span class="text-muted">Metode Pembayaran</span>
                    <strong>{{ $order->payment_method_label }}</strong>
                </div>
                <div class="border rounded-3 p-3 mb-3 d-flex justify-content-between">
                    <span class="text-muted">Payment Status</span>
                    <strong class="badge {{ $order->payment_status === Order::PAYMENT_STATUS_PAID ? 'text-bg-success' : 'text-bg-warning' }}">{{ $order->payment_status_label }}</strong>
                </div>
                <div class="border rounded-3 p-3 mb-4 d-flex justify-content-between">
                    <span class="text-muted">Total Payment</span>
                    <strong>Rp {{ number_format($order->display_total, 0, ',', '.') }}</strong>
                </div>

                @if ($order->receipt_number)
                    <div class="border rounded-3 p-3 mb-4 d-flex justify-content-between">
                        <span class="text-muted">Nomor Kwitansi</span>
                        <strong>{{ $order->receipt_number }}</strong>
                    </div>
                @endif

                <div class="border rounded-3 p-3 mb-4 text-start">
                    <div class="small text-muted">Penerima</div>
                    <div class="fw-semibold">{{ $order->nama_penerima }}</div>
                    <div class="small text-muted mt-2">Alamat Pengiriman</div>
                    <div>{{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</div>
                    <div class="small mt-1">HP: {{ $order->phone }}</div>
                </div>

                @if ($order->isBankTransferPayment() && $order->status === Order::STATUS_PENDING)
                    <div class="alert alert-warning text-start mb-4">
                        <div class="fw-semibold mb-2">Langkah Transfer</div>
                        <div>BCA: 1234567890 a.n. BookStore Nusantara</div>
                        <div>BRI: 9876543210 a.n. BookStore Nusantara</div>
                        <div>Mandiri: 1122334455 a.n. BookStore Nusantara</div>
                    </div>
                    <form action="{{ route('orders.confirm-transfer', $order) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning w-100">Saya sudah transfer</button>
                    </form>
                @endif

                @if ($order->isOfflinePayment())
                    <div class="alert alert-info text-start mb-4">
                        Silakan lakukan pembayaran langsung ke admin.
                    </div>
                @endif
            </div>

            <a href="{{ route('orders.index') }}" class="btn btn-navy">Lihat Order Saya</a>
        </div>
    </div>
@endsection
