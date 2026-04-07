@extends('admin.layouts.app', ['title' => 'Edit Promo'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Edit Promo</h3>
            <p class="text-muted mb-0">Perbarui detail promo yang dipilih.</p>
        </div>
        <a href="{{ route('admin.promos.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <form action="{{ route('admin.promos.update', $promo) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-6">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $promo->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Discount (%)</label>
                    <input type="number" name="discount" min="1" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount', $promo->discount) }}" placeholder="Contoh: 20">
                    @error('discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $promo->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date', optional($promo->start_date)->format('Y-m-d')) }}">
                    @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date', optional($promo->end_date)->format('Y-m-d')) }}">
                    @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Image Banner (opsional)</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $promo->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktifkan promo</label>
                    </div>
                </div>

                @if ($promo->image)
                    <div class="col-12">
                        <img src="{{ asset('storage/' . $promo->image) }}" alt="{{ $promo->title }}" class="rounded" style="height: 150px; width: auto; max-width: 100%; object-fit: cover; border: 1px solid #dfe4ee;">
                    </div>
                @endif

                <div class="col-12 pt-2">
                    <button type="submit" class="btn btn-navy">Update Promo</button>
                </div>
            </form>
        </div>
    </div>
@endsection
