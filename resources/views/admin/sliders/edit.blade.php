@extends('admin.layouts.app', ['title' => 'Edit Slider'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Edit Slider</h3>
            <p class="text-muted mb-0">Perbarui konten hero slide.</p>
        </div>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $slider->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price (optional)</label>
                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $slider->price) }}" placeholder="Contoh: Rp 105.000">
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Subtitle</label>
                    <textarea name="subtitle" rows="3" class="form-control @error('subtitle') is-invalid @enderror">{{ old('subtitle', $slider->subtitle) }}</textarea>
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button Text (optional)</label>
                    <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $slider->button_text) }}" placeholder="Contoh: Lihat Detail">
                    @error('button_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button Link (optional)</label>
                    <input type="text" name="button_link" class="form-control @error('button_link') is-invalid @enderror" value="{{ old('button_link', $slider->button_link) }}" placeholder="Contoh: /books/1">
                    @error('button_link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Image {{ $slider->image ? '(kosongkan jika tidak diganti)' : '' }}</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktifkan slider</label>
                    </div>
                </div>

                @if ($slider->image)
                    <div class="col-12">
                        <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="rounded" style="height: 140px; width: auto; max-width: 100%; object-fit: cover; border: 1px solid #dfe4ee;">
                    </div>
                @endif

                <div class="col-12 pt-2">
                    <button type="submit" class="btn btn-navy">Update Slider</button>
                </div>
            </form>
        </div>
    </div>
@endsection
