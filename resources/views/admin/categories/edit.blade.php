@extends('admin.layouts.app', ['title' => 'Edit Category'])

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">Edit Category</h3>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card card-elegant">
        <div class="card-body p-4">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Category</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-navy">Update</button>
            </form>
        </div>
    </div>
@endsection
