@extends('admin.layouts.app', ['title' => 'Detail Order'])

@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h3 class="mb-1">Detail Order</h3>
            <p class="text-muted mb-0">Informasi lengkap order dan item pembelian user.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Kembali</a>
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
                    <div class="fw-semibold mb-3">{{ $order->payment_method }}</div>

                    <div class="small text-muted mb-1">Status</div>
                    <div class="mb-3">
                        <span class="badge text-capitalize {{ $order->status === 'completed' ? 'text-bg-success' : ($order->status === 'processing' ? 'text-bg-primary' : 'text-bg-warning') }}">
                            {{ $order->status === 'completed' ? 'Completed (Locked)' : $order->status }}
                        </span>
                    </div>

                    <div class="small text-muted mb-1">Total Payment</div>
                    <div class="fw-semibold mb-3">Rp {{ number_format($order->display_total, 0, ',', '.') }}</div>

                    <div class="small text-muted mb-1">Alamat Pengiriman</div>
                    <div class="fw-semibold mb-3">{{ $order->nama_penerima }} | {{ $order->phone }}<br>{{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</div>

                    @if ($order->status === 'completed')
                        <div class="alert alert-success mb-0">Completed (Locked)</div>
                    @else
                        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label class="form-label">Update Status</label>
                            <div class="d-flex gap-2">
                                <select name="status" class="form-select">
                                    @if ($order->status === 'pending' || $order->status === 'menunggu verifikasi')
                                        <option value="processing">processing</option>
                                        @if ($order->payment_method === 'COD')
                                            <option value="completed">completed</option>
                                        @endif
                                    @elseif ($order->status === 'processing')
                                        <option value="completed">completed</option>
                                    @endif
                                </select>
                                <button class="btn btn-navy" type="submit">Simpan</button>
                            </div>
                        </form>
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
