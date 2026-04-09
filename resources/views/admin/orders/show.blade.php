@extends('admin.layouts.app', ['title' => 'Detail Order'])

@php
    use App\Models\Order;
@endphp

@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h3 class="mb-1">Detail Order</h3>
            <p class="text-muted mb-0">Informasi lengkap order dan item pembelian user.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('invoice.show', $order->id) }}" class="btn btn-dark">Lihat Invoice</a>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-elegant h-100">
                <div class="card-body">
                    <h5 class="mb-3">Informasi Order</h5>
                    <div class="small text-muted mb-1">Order Code</div>
                    <div class="fw-semibold mb-3">{{ $order->order_code }}</div>

                    <div class="small text-muted mb-1">User</div>
                    <div class="fw-semibold mb-3">{{ $order->user?->name ?? '-' }}</div>

                    <div class="small text-muted mb-1">Payment Method</div>
                    <div class="fw-semibold mb-3">{{ $order->payment_method_label }}</div>

                    <div class="small text-muted mb-1">Payment Status</div>
                    <div class="mb-3">
                        <span class="badge {{ $order->payment_status === Order::PAYMENT_STATUS_PAID ? 'text-bg-primary' : 'text-bg-warning' }}">
                            {{ $order->payment_status_label }}
                        </span>
                    </div>

                    <div class="small text-muted mb-1">Nomor Kwitansi</div>
                    <div class="fw-semibold mb-3">{{ $order->receipt_number ?? '-' }}</div>

                    <div class="small text-muted mb-1">Status</div>
                    <div class="mb-3">
                        <span class="badge {{ $order->status_badge_class }}">
                            {{ $order->status_label }}
                        </span>
                    </div>

                    <div class="small text-muted mb-1">Total Payment</div>
                    <div class="fw-semibold mb-3">Rp {{ number_format($order->display_total, 0, ',', '.') }}</div>

                    <div class="small text-muted mb-1">Alamat Pengiriman</div>
                    <div class="fw-semibold mb-3">{{ $order->nama_penerima }} | {{ $order->phone }}<br>{{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</div>

                    @if ($order->status === Order::STATUS_COMPLETED)
                        <div class="alert alert-success mb-0">Completed (Locked)</div>
                    @elseif ($order->status === Order::STATUS_CANCELLED)
                        <div class="alert alert-danger mb-0">Cancelled (Locked)</div>
                    @else
                        @if ($order->isOfflinePayment() && $order->payment_status !== Order::PAYMENT_STATUS_PAID)
                            <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST" class="mb-3">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success w-100" type="submit">Konfirmasi Pembayaran</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label class="form-label">Update Status</label>
                            <div class="d-flex gap-2">
                                <select name="status" class="form-select">
                                    @if ($order->status === Order::STATUS_PENDING)
                                        <option value="paid">paid</option>
                                    @elseif ($order->status === Order::STATUS_PAID)
                                        <option value="processing">processing</option>
                                    @elseif ($order->status === Order::STATUS_PROCESSING)
                                        <option value="shipped">shipped</option>
                                    @elseif ($order->status === Order::STATUS_SHIPPED)
                                        <option value="completed">completed</option>
                                    @endif
                                </select>
                                <button class="btn btn-navy" type="submit">Simpan</button>
                            </div>
                        </form>

                        @if (in_array($order->status, [Order::STATUS_PENDING, Order::STATUS_PAID, Order::STATUS_PROCESSING], true))
                            <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" class="mt-2" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-outline-danger w-100" type="submit">Batal Pesanan</button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-elegant h-100">
                <div class="card-body">
                    <h5 class="mb-3">Item Order</h5>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($order->orderDetails as $detail)
                                <tr>
                                    <td>{{ $detail->book?->title ?? '-' }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">Tidak ada item pada order ini.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
