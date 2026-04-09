@extends('admin.layouts.app', ['title' => 'Monitoring Orders'])

@php
    use App\Models\Order;
@endphp

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h3 class="mb-1">Monitoring Orders</h3>
            <p class="text-muted mb-0">Pantau semua transaksi dan ubah status order dari panel admin.</p>
        </div>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th>Order Code</th>
                        <th>User</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment Method</th>
                        <th>Payment Status</th>
                        <th>Kwitansi</th>
                        <th>Items</th>
                        <th>Tanggal</th>
                        <th class="text-end" style="width: 360px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->user?->name ?? '-' }}</td>
                            <td>Rp {{ number_format($order->display_total, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge {{ $order->status_badge_class }}">
                                    {{ $order->status_label }}
                                </span>
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
                            <td class="text-end">
                                <div class="d-inline-flex align-items-center gap-2 flex-wrap justify-content-end">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                                    <a href="{{ route('invoice.show', $order->id) }}" class="btn btn-sm btn-outline-dark">Invoice</a>

                                    @if ($order->isOfflinePayment() && $order->payment_status !== Order::PAYMENT_STATUS_PAID)
                                        <form action="{{ route('admin.orders.confirm-payment', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">Konfirmasi Pembayaran</button>
                                        </form>
                                    @endif

                                    @if ($order->status === Order::STATUS_COMPLETED)
                                        <span class="badge text-bg-success">Completed (Locked)</span>
                                    @elseif ($order->status === Order::STATUS_CANCELLED)
                                        <span class="badge text-bg-danger">Cancelled (Locked)</span>
                                    @else
                                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline-flex gap-1">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm">
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
                                            <button type="submit" class="btn btn-sm btn-navy">Update</button>
                                        </form>

                                        @if (in_array($order->status, [Order::STATUS_PENDING, Order::STATUS_PAID, Order::STATUS_PROCESSING], true))
                                            <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Batal Pesanan</button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">Belum ada order.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $orders->links() }}
    </div>
@endsection
