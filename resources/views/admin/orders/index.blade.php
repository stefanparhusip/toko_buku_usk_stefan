@extends('admin.layouts.app', ['title' => 'Monitoring Orders'])

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
                        <th>Payment</th>
                        <th>Items</th>
                        <th>Tanggal</th>
                        <th class="text-end" style="width: 270px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($orders as $order)
                        @php
                            $statusClass = $order->status === 'completed'
                                ? 'text-bg-success'
                                : ($order->status === 'processing' ? 'text-bg-primary' : 'text-bg-warning');
                        @endphp
                        <tr>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->user?->name ?? '-' }}</td>
                            <td>Rp {{ number_format($order->display_total, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge text-capitalize {{ $statusClass }}">
                                    {{ $order->status === 'completed' ? 'Completed (Locked)' : $order->status }}
                                </span>
                            </td>
                            <td>{{ $order->payment_method }}</td>
                            <td>{{ $order->orderDetails->sum('quantity') }}</td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex align-items-center gap-2 flex-wrap justify-content-end">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">Detail</a>

                                    @if ($order->status === 'completed')
                                        <span class="badge text-bg-success">Completed (Locked)</span>
                                    @else
                                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="d-inline-flex gap-1">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm">
                                                @if ($order->status === 'pending' || $order->status === 'menunggu verifikasi')
                                                    <option value="processing">processing</option>
                                                    @if ($order->payment_method === 'COD')
                                                        <option value="completed">completed</option>
                                                    @endif
                                                @elseif ($order->status === 'processing')
                                                    <option value="completed">completed</option>
                                                @endif
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-navy">Update</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada order.</td>
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
