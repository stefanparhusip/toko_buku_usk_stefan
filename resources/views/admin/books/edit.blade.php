@extends('admin.layouts.app', ['title' => 'Edit Book'])

@section('content')
    <style>
        .book-admin-head {
            border-radius: 0.95rem;
            padding: 0.9rem 1rem;
            color: #eff5ff;
            background: linear-gradient(132deg, #0a1f44 0%, #11386f 100%);
            box-shadow: 0 12px 26px rgba(10, 31, 68, 0.22);
            margin-bottom: 1rem;
        }

        .book-admin-head .sub {
            opacity: 0.88;
            font-size: 0.88rem;
        }
    </style>

    <div class="book-admin-head">
        <div class="fw-semibold">Admin BookStore</div>
        <div class="sub">Panel manajemen katalog dengan tema navy elegan</div>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Edit Book</h3>
        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card card-elegant">
        <div class="card-body p-4">
            <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $book->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $book->category_id) == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" id="author" name="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', $book->author) }}" required>
                        @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="publisher" class="form-label">Publisher</label>
                        <input type="text" id="publisher" name="publisher" class="form-control @error('publisher') is-invalid @enderror" value="{{ old('publisher', $book->publisher) }}" required>
                        @error('publisher')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="year" class="form-label">Year</label>
                        <input type="text" id="year" name="year" class="form-control @error('year') is-invalid @enderror" value="{{ old('year', $book->year) }}" required>
                        @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $book->price) }}" min="0" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" id="stock" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $book->stock) }}" min="0" required>
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $book->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label d-block">Image Saat Ini</label>
                        @if ($book->image_source)
                            <img src="{{ $book->image_source }}" alt="{{ $book->title }}" class="rounded mb-2" style="width: 96px; height: 96px; object-fit: cover;">
                        @endif
                        <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <small class="text-muted">Opsi 1: upload gambar baru.</small>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label for="image_url" class="form-label">Image Address (URL)</label>
                        <input type="url" id="image_url" name="image_url" class="form-control @error('image_url') is-invalid @enderror" value="{{ old('image_url', $book->image_url) }}" placeholder="https://example.com/cover.jpg">
                        <small class="text-muted">Opsi 2: isi link gambar. Jika diisi, URL diprioritaskan.</small>
                        @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label d-block">Kontrol Homepage</label>
                        <div class="d-flex flex-wrap gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $book->is_featured))>
                                <label class="form-check-label" for="is_featured">Best Seller</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_recommended" name="is_recommended" value="1" @checked(old('is_recommended', $book->is_recommended))>
                                <label class="form-check-label" for="is_recommended">Rekomendasi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_new" name="is_new" value="1" @checked(old('is_new', $book->is_new))>
                                <label class="form-check-label" for="is_new">Buku Terbaru</label>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-navy mt-4">Update</button>
            </form>
        </div>
    </div>
@endsection
