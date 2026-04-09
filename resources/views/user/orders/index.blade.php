@extends('user.layouts.app', ['title' => 'My Orders'])

@php
    use App\Models\Order;
@endphp

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">My Orders</h2>
            <p class="text-muted mb-0">Daftar pesanan Anda.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('orders.history') }}" class="btn btn-outline-primary">History Pembelian</a>
            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Belanja Lagi</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($orders->isEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center text-muted">
                Belum ada order.
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th>Order Code</th>
                            <th>Penerima</th>
                            <th>Total Payment</th>
                            <th>Status</th>
                            <th>Payment Method</th>
                            <th>Payment Status</th>
                            <th>Kwitansi</th>
                            <th>Items</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            @php
                                $canCancel = in_array($order->status, [Order::STATUS_PENDING, Order::STATUS_PAID, Order::STATUS_PROCESSING], true);
                            @endphp
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $order->nama_penerima }}</div>
                                    <div class="small text-muted">{{ $order->phone }}</div>
                                </td>
                                <td>Rp {{ number_format($order->display_total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $order->status_badge_class }}">{{ $order->status_label }}</span>
                                </td>
                                <td>{{ $order->payment_method_label }}</td>
                                <td>
                                    <span class="badge {{ $order->payment_status === Order::PAYMENT_STATUS_PAID ? 'text-bg-primary' : 'text-bg-warning' }}">
                                        {{ $order->payment_status_label }}
                                    </span>
                                </td>
                                <td>{{ $order->receipt_number ?? '-' }}</td>
                                <td>{{ $order->orderDetails->sum('quantity') }}</td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('invoice.show', $order->id) }}" class="btn btn-sm btn-outline-dark">Invoice</a>

                                        @if ($order->isBankTransferPayment() && $order->status === Order::STATUS_PENDING)
                                            <form action="{{ route('orders.confirm-transfer', $order) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-warning">Saya sudah transfer</button>
                                            </form>
                                        @endif

                                        @if ($canCancel)
                                            <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan order ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Batalkan</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10" class="pt-0 border-0">
                                    <div class="small text-muted">Alamat: {{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
@endsection
