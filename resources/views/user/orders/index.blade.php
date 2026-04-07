@extends('user.layouts.app', ['title' => 'My Orders'])

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
                            <th>Payment</th>
                            <th>Items</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            @php
                                $statusLabel = $order->status === 'completed' ? 'selesai' : $order->status;
                                $statusBadge = $order->status === 'completed'
                                    ? 'text-bg-success'
                                    : ($order->status === 'processing'
                                        ? 'text-bg-primary'
                                        : ($order->status === 'menunggu verifikasi' ? 'text-bg-warning' : 'text-bg-secondary'));
                            @endphp
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $order->nama_penerima }}</div>
                                    <div class="small text-muted">{{ $order->phone }}</div>
                                </td>
                                <td>Rp {{ number_format($order->display_total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge text-capitalize {{ $statusBadge }}">{{ $statusLabel }}</span>
                                </td>
                                <td>{{ $order->payment_method }}</td>
                                <td>{{ $order->orderDetails->sum('quantity') }}</td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    @if ($order->payment_method === 'BANK_TRANSFER' && $order->status === 'pending')
                                        <form action="{{ route('orders.confirm-transfer', $order) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-warning">Saya sudah transfer</button>
                                        </form>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" class="pt-0 border-0">
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
