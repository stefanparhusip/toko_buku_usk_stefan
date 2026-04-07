@extends('admin.layouts.app', ['title' => 'User Management'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">User Management</h3>
            <p class="text-muted mb-0">Daftar user yang terdaftar pada aplikasi BookStore.</p>
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
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Registered</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone ?: '-' }}</td>
                            <td>{{ $user->address ?: '-' }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data user.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $users->links() }}
    </div>
@endsection
