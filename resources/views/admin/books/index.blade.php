@extends('admin.layouts.app', ['title' => 'Book List'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Book List</h3>
            <p class="text-muted mb-0">Kelola katalog buku Book Market.</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn btn-navy">+ Tambah Book</a>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th style="width: 90px;">Image</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Homepage</th>
                        <th class="text-end" style="width: 180px;">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $books->firstItem() + $loop->index }}</td>
                            <td>
                                <img src="{{ $book->image_source ?: 'https://placehold.co/112x112?text=No+Image' }}" alt="{{ $book->title }}" class="rounded" style="width: 56px; height: 56px; object-fit: cover;">
                            </td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->category->name }}</td>
                            <td>{{ $book->author }}</td>
                            <td>Rp {{ number_format($book->price, 0, ',', '.') }}</td>
                            <td>{{ $book->stock }}</td>
                            <td>
                                <div class="d-flex flex-wrap gap-1">
                                    @if ($book->is_featured)
                                        <span class="badge text-bg-primary">Best Seller</span>
                                    @endif
                                    @if ($book->is_recommended)
                                        <span class="badge text-bg-success">Rekomendasi</span>
                                    @endif
                                    @if ($book->is_new)
                                        <span class="badge text-bg-info">Terbaru</span>
                                    @endif
                                    @if (! $book->is_featured && ! $book->is_recommended && ! $book->is_new)
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus book ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Belum ada data book.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $books->links() }}
    </div>
@endsection
