@extends('admin.layouts.app', ['title' => 'Slider List'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Hero Slider</h3>
            <p class="text-muted mb-0">Kelola banner slider untuk homepage user.</p>
        </div>
        <a href="{{ route('admin.sliders.create') }}" class="btn btn-navy">+ Tambah Slider</a>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 100px;">Image</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Button</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 180px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($sliders as $slider)
                        <tr>
                            <td>{{ $sliders->firstItem() + $loop->index }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="rounded" style="width: 68px; height: 48px; object-fit: cover;">
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $slider->title }}</div>
                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($slider->subtitle, 60) }}</small>
                            </td>
                            <td>{{ $slider->price ?: '-' }}</td>
                            <td>
                                @if ($slider->button_text)
                                    <span class="badge text-bg-light border">{{ $slider->button_text }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($slider->is_active)
                                    <span class="badge text-bg-success">Active</span>
                                @else
                                    <span class="badge text-bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus slider ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data slider.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $sliders->links() }}
    </div>
@endsection
