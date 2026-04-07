@extends('admin.layouts.app', ['title' => 'Promo List'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Promo List</h3>
            <p class="text-muted mb-0">Kelola promo aktif untuk halaman user.</p>
        </div>
        <a href="{{ route('admin.promos.create') }}" class="btn btn-navy">+ Tambah Promo</a>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 100px;">Banner</th>
                        <th>Title</th>
                        <th>Discount</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 180px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($promos as $promo)
                        <tr>
                            <td>{{ $promos->firstItem() + $loop->index }}</td>
                            <td>
                                <img
                                    src="{{ $promo->image ? asset('storage/' . $promo->image) : 'https://placehold.co/300x180?text=Promo' }}"
                                    alt="{{ $promo->title }}"
                                    class="rounded"
                                    style="width: 72px; height: 48px; object-fit: cover;"
                                >
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $promo->title }}</div>
                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($promo->description, 60) }}</small>
                            </td>
                            <td>
                                @if ($promo->discount)
                                    <span class="badge text-bg-primary">{{ $promo->discount }}%</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{ $promo->start_date ? $promo->start_date->format('d M Y') : '-' }}
                                -
                                {{ $promo->end_date ? $promo->end_date->format('d M Y') : '-' }}
                            </td>
                            <td>
                                @if ($promo->is_active)
                                    <span class="badge text-bg-success">Active</span>
                                @else
                                    <span class="badge text-bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus promo ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada promo tersedia.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $promos->links() }}
    </div>
@endsection
