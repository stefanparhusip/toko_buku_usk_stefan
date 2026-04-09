@extends('admin.layouts.app', ['title' => 'User Management'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h3 class="mb-1">User Management</h3>
            <p class="text-muted mb-0">Daftar user yang terdaftar pada aplikasi BookStore.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-navy">+ Tambah User</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card card-elegant mb-3">
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-8 col-lg-9">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ $search ?? '' }}"
                        placeholder="Cari nama atau email..."
                    >
                </div>
                <div class="col-md-4 col-lg-3 d-grid d-md-flex gap-2">
                    <button class="btn btn-navy w-100" type="submit">Search</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Registered</th>
                        <th class="text-end" style="width: 310px;">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role === 'admin' ? 'text-bg-danger' : 'text-bg-primary' }} text-uppercase">{{ $user->role }}</span>
                            </td>
                            <td>{{ $user->phone ?: '-' }}</td>
                            <td>{{ $user->address ?: '-' }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1 flex-wrap justify-content-end">
                                    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-dark">Detail</a>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>

                                    <form action="{{ route('admin.users.reset-password', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-warning">Reset Password</button>
                                    </form>

                                    <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteUserModal{{ $user->id }}"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Hapus User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Yakin ingin menghapus user ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data user.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $users->appends(['search' => $search ?? ''])->links() }}
    </div>
@endsection
