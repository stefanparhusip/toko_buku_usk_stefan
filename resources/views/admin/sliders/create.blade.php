@extends('admin.layouts.app', ['title' => 'Create Slider'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Tambah Slider</h3>
            <p class="text-muted mb-0">Buat hero slide baru untuk homepage.</p>
        </div>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf

                <div class="col-md-6">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price (optional)</label>
                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="Contoh: Rp 105.000">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Subtitle</label>
                    <textarea name="subtitle" rows="3" class="form-control @error('subtitle') is-invalid @enderror">{{ old('subtitle') }}</textarea>
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button Text (optional)</label>
                    <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text') }}" placeholder="Contoh: Lihat Detail">
                    @error('button_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button Link (optional)</label>
                    <input type="text" name="button_link" class="form-control @error('button_link') is-invalid @enderror" value="{{ old('button_link') }}" placeholder="Contoh: /books/1">
                    @error('button_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Image <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktifkan slider</label>
                    </div>
                </div>

                <div class="col-12 pt-2">
                    <button type="submit" class="btn btn-navy">Simpan Slider</button>
                </div>
            </form>
        </div>
    </div>
@endsection
