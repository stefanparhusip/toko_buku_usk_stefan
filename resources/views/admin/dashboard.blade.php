@extends('admin.layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
        <div>
            <h3 class="mb-1">Ringkasan Kinerja Toko</h3>
            <p class="text-muted mb-0">Pantau performa katalog, user, dan transaksi secara real-time.</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-navy">
            <i class="fa-solid fa-basket-shopping me-1"></i> Monitoring Order
        </a>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card card-elegant h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="text-muted mb-2">Total Buku</p>
                        <i class="fa-solid fa-book text-primary"></i>
                    </div>
                    <h2 class="mb-0">{{ $stats['books'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-elegant h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="text-muted mb-2">Total Kategori</p>
                        <i class="fa-solid fa-list text-info"></i>
                    </div>
                    <h2 class="mb-0">{{ $stats['categories'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-elegant h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="text-muted mb-2">Total User</p>
                        <i class="fa-solid fa-users text-success"></i>
                    </div>
                    <h2 class="mb-0">{{ $stats['users'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card card-elegant h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="text-muted mb-2">Total Order</p>
                        <i class="fa-solid fa-bag-shopping" style="color:#f0a100;"></i>
                    </div>
                    <h2 class="mb-0">{{ $stats['orders'] }}</h2>
                    <small class="text-muted">Pending: {{ $stats['pendingOrders'] }}</small>
                </div>
            </div>
        </div>
    </div>
@endsection
