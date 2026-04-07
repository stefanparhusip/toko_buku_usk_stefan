@extends('user.layouts.app', ['title' => 'Cart'])

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="section-title mb-1">Cart</h2>
            <p class="text-muted mb-0">Kelola item belanja Anda dengan mudah.</p>
        </div>
        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Lanjut Belanja</a>
    </div>

    @if ($cartItems->isEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5 text-center text-muted">
                Cart kosong
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Buku</th>
                            <th>Harga</th>
                            <th style="width: 180px;">Quantity</th>
                            <th>Total</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>
                                    <img src="{{ $item->book?->image_source ?: 'https://placehold.co/100x100?text=No+Image' }}" alt="{{ $item->book?->title }}" class="rounded" style="width: 64px; height: 64px; object-fit: cover;">
                                </td>
                                <td>{{ $item->book?->title ?? '-' }}</td>
                                <td>{{ $item->book?->formatted_price ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" min="1" max="{{ $item->book?->stock ?? 1 }}" value="{{ $item->quantity }}" class="form-control form-control-sm" required>
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                    </form>
                                </td>
                                <td>Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus item ini dari cart?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <div class="card border-0 shadow-sm rounded-3" style="min-width: 360px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Grand Total</span>
                        <span class="h5 mb-0 text-primary">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-navy w-100">Lanjut Checkout</a>
                </div>
            </div>
        </div>
    @endif
@endsection
