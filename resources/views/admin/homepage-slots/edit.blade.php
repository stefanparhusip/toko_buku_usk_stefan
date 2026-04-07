@extends('admin.layouts.app', ['title' => 'Edit Homepage Slot'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Edit {{ $slot->title ?: 'Slot '.$slot->position }}</h3>
            <p class="text-muted mb-0">Atur konten slot untuk tampilan homepage.</p>
        </div>
        <a href="{{ route('admin.homepage-slots.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <form action="{{ route('admin.homepage-slots.update', $slot) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-4">
                    <label class="form-label">Position</label>
                    <input type="number" class="form-control" value="{{ $slot->position }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tipe Slot</label>
                    <input type="text" class="form-control text-capitalize" value="{{ $slot->type }}" readonly>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $slot->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktifkan slot</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Title / Nama Slot <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $slot->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Link (optional)</label>
                    <input type="text" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $slot->link) }}" placeholder="Contoh: /books atau https://example.com">
                    @error('link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $slot->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Image {{ $slot->image_source ? '(kosongkan jika tidak diganti)' : '' }}</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Opsi 1: upload gambar dari perangkat.</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Image URL (optional)</label>
                    <input type="url" name="image_url" class="form-control @error('image_url') is-invalid @enderror" value="{{ old('image_url', $slot->image_url) }}" placeholder="https://example.com/image.jpg">
                    <small class="text-muted">Opsi 2: pakai link gambar. Jika diisi, link akan diprioritaskan daripada file lama.</small>
                    @error('image_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Pilih Buku (untuk slot type book)</label>
                    <select name="book_id" class="form-select @error('book_id') is-invalid @enderror" {{ $slot->type === 'book' ? '' : 'disabled' }}>
                        <option value="">-- Tidak ada buku --</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}" {{ (string) old('book_id', $slot->book_id) === (string) $book->id ? 'selected' : '' }}>{{ $book->title }}</option>
                        @endforeach
                    </select>
                    @if ($slot->type !== 'book')
                        <small class="text-muted">Slot ini bukan tipe book, jadi pilihan buku tidak digunakan.</small>
                    @endif
                    @error('book_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if ($slot->image_source)
                    <div class="col-12">
                        <img src="{{ $slot->image_source }}" alt="{{ $slot->title }}" class="rounded" style="height: 150px; width: auto; max-width: 100%; object-fit: cover; border: 1px solid #dfe4ee;">
                    </div>
                @endif

                <div class="col-12 pt-2">
                    <button type="submit" class="btn btn-navy">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
