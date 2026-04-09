@extends('admin.layouts.app', ['title' => 'Detail User'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h3 class="mb-1">Detail User</h3>
            <p class="text-muted mb-0">Informasi lengkap user terdaftar.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-navy">Edit</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Kembali</a>
        </div>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="small text-muted">Nama</div>
                    <div class="fw-semibold">{{ $user->name }}</div>
                </div>
                <div class="col-md-6">
                    <div class="small text-muted">Email</div>
                    <div class="fw-semibold">{{ $user->email }}</div>
                </div>
                <div class="col-md-6">
                    <div class="small text-muted">Phone</div>
                    <div class="fw-semibold">{{ $user->phone ?: '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="small text-muted">Role</div>
                    <div>
                        <span class="badge {{ $user->role === 'admin' ? 'text-bg-danger' : 'text-bg-primary' }} text-uppercase">{{ $user->role }}</span>
                    </div>
                </div>
                <div class="col-12">
                    <div class="small text-muted">Address</div>
                    <div class="fw-semibold">{{ $user->address ?: '-' }}</div>
                </div>
                <div class="col-md-6">
                    <div class="small text-muted">Terdaftar</div>
                    <div class="fw-semibold">{{ $user->created_at?->format('d M Y H:i') }}</div>
                </div>
                <div class="col-md-6">
                    <div class="small text-muted">Terakhir Update</div>
                    <div class="fw-semibold">{{ $user->updated_at?->format('d M Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
