@extends('user.layouts.app', ['title' => 'History Pembelian'])

@php
    use App\Models\Order;
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="section-title mb-1">History Pembelian</h2>
            <p class="text-muted mb-0">Semua riwayat transaksi pembelian Anda tersimpan di sini.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">Kembali ke Orders</a>
            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Belanja Lagi</a>
        </div>
    </div>

    @if ($orders->isEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center text-muted">
                Belum ada history pembelian.
            </div>
        </div>
    @else
        <div class="row g-3">
            @foreach ($orders as $order)
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                                <div>
                                    <div class="small text-muted">Order Code</div>
                                    <div class="fw-semibold">{{ $order->order_code }}</div>
                                </div>
                                <span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span>
                            </div>

                            <div class="row g-2 small mb-3">
                                <div class="col-md-3"><span class="text-muted">Penerima:</span> {{ $order->nama_penerima }}</div>
                                <div class="col-md-3"><span class="text-muted">HP:</span> {{ $order->phone }}</div>
                                <div class="col-md-3"><span class="text-muted">Payment:</span> {{ $order->payment_method_label }}</div>
                                <div class="col-md-3"><span class="text-muted">Tanggal:</span> {{ $order->created_at->format('d M Y H:i') }}</div>
                            </div>

                            <div class="row g-2 small mb-3">
                                <div class="col-md-3">
                                    <span class="text-muted">Payment Status:</span>
                                    <span class="badge {{ $order->payment_status === Order::PAYMENT_STATUS_PAID ? 'text-bg-primary' : 'text-bg-warning' }}">{{ $order->payment_status_label }}</span>
                                </div>
                                <div class="col-md-9"><span class="text-muted">Nomor Kwitansi:</span> {{ $order->receipt_number ?? '-' }}</div>
                            </div>

                            <div class="small text-muted mb-3">Alamat: {{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</div>

                            <div class="table-responsive">
                                <table class="table table-sm align-middle mb-0">
                                    <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Subtotal</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($order->orderDetails as $detail)
                                        <tr>
                                            <td>{{ $detail->book?->title ?? '-' }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                            <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-end mt-3 fw-semibold text-primary">
                                Total: Rp {{ number_format($order->display_total, 0, ',', '.') }}
                            </div>

                            <div class="text-end mt-2">
                                <a href="{{ route('invoice.show', $order->id) }}" class="btn btn-sm btn-outline-dark">Lihat Invoice</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
@endsection
