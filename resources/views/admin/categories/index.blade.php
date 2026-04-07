@extends('admin.layouts.app', ['title' => 'Category List'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Category List</h3>
            <p class="text-muted mb-0">Kelola seluruh kategori buku.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-navy">+ Tambah Category</a>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>Nama Category</th>
                        <th class="text-end" style="width: 180px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $categories->firstItem() + $loop->index }}</td>
                            <td>{{ $category->name }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus category ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Belum ada data category.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $categories->links() }}
    </div>
@endsection
