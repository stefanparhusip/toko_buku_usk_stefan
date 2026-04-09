@extends('admin.layouts.app', ['title' => 'Edit Homepage Slot'])

@section('content')
    <style>
        .item-thumb {
            width: 72px;
            height: 52px;
            border-radius: 0.55rem;
            border: 1px solid #d8e4f4;
            object-fit: cover;
            background: #eef3fb;
        }

        .slide-sort-list {
            list-style: none;
            margin: 0;
            padding: 0;
            border: 1px solid #d8e4f4;
            border-radius: 0.85rem;
            background: #f7f9fd;
        }

        .slide-sort-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.7rem 0.9rem;
            border-bottom: 1px solid #e7eef9;
            cursor: move;
            background: #fff;
        }

        .slide-sort-item:last-child {
            border-bottom: 0;
        }

        .slide-sort-item.dragging {
            opacity: 0.58;
        }

        .drag-handle {
            color: #4d668d;
            font-size: 1rem;
            font-weight: 700;
            line-height: 1;
            user-select: none;
        }
    </style>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Edit {{ $slot->title ?: 'Slot '.$slot->slot_number }}</h3>
            <p class="text-muted mb-0">Atur konten slot untuk tampilan homepage.</p>
        </div>
        <a href="{{ route('admin.homepage-slots.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card card-elegant mb-4">
        <div class="card-body">
            <form action="{{ route('admin.homepage-slots.update', $slot) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-4">
                    <label class="form-label">Position</label>
                    <input type="number" class="form-control" value="{{ $slot->slot_number ?? $slot->position }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tipe Slot</label>
                    <input type="text" class="form-control text-capitalize" value="{{ $slot->type }}" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Urutan Slot</label>
                    <input
                        type="number"
                        name="order_number"
                        min="1"
                        class="form-control @error('order_number') is-invalid @enderror"
                        value="{{ old('order_number', $slot->order_number ?? 1) }}"
                        {{ (int) ($slot->slot_number ?? 0) !== 1 ? 'readonly' : '' }}
                    >
                    @if ((int) ($slot->slot_number ?? 0) !== 1)
                        <small class="text-muted">Slot selain Slot 1 menggunakan urutan tetap.</small>
                    @endif
                    @error('order_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

                <div class="col-md-6">
                    <label class="form-label">Button Text</label>
                    <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $slot->button_text) }}" placeholder="Contoh: Lihat Detail">
                    @error('button_text')
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

    <div class="card card-elegant mb-4">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <h5 class="mb-0">Item Konten Slot</h5>
                <span class="badge text-bg-light border">Total: {{ $slot->items->count() }} item</span>
            </div>

            <form action="{{ route('admin.homepage-slots.items.store', $slot) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                @csrf
                <div class="col-12">
                    <h6 class="mb-0">+ Tambah Slide</h6>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Title Item <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Order Number <span class="text-danger">*</span></label>
                    <input type="number" name="order_number" min="1" class="form-control @error('order_number') is-invalid @enderror" value="{{ old('order_number', 1) }}" required>
                    @error('order_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="item_is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="item_is_active">Aktifkan item</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Image Upload (opsional)</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Opsi 1: upload gambar dari perangkat.</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Image URL (optional)</label>
                    <input type="url" name="image_url" class="form-control @error('image_url') is-invalid @enderror" value="{{ old('image_url') }}" placeholder="https://example.com/image.jpg">
                    <small class="text-muted">Opsi 2: pakai link gambar. Jika diisi, URL diprioritaskan dari file lama.</small>
                    @error('image_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <small class="text-muted">Wajib isi minimal salah satu: Image Upload atau Image URL.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Link Tujuan</label>
                    <input type="text" name="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="/books/1 atau /promo">
                    @error('link')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Button Text</label>
                    <input type="text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text') }}" placeholder="Contoh: Lihat Detail">
                    @error('button_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 pt-1">
                    <button type="submit" class="btn btn-navy">Tambah Item</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <h5 class="mb-3">Daftar Slide Slot</h5>

            @if ((int) ($slot->slot_number ?? $slot->position ?? 0) === 1 && $slot->items->isNotEmpty())
                <div class="mb-3">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                        <h6 class="mb-0">Urutkan Slide (Drag & Drop)</h6>
                        <small class="text-muted">Geser item untuk ubah urutan, lalu klik Simpan Urutan.</small>
                    </div>

                    <form action="{{ route('admin.homepage-slots.items.reorder', $slot) }}" method="POST" id="slideSortForm">
                        @csrf
                        @method('PATCH')

                        <ul class="slide-sort-list" id="slideSortList">
                            @foreach ($slot->items as $item)
                                <li class="slide-sort-item" draggable="true" data-item-id="{{ $item->id }}">
                                    <span class="drag-handle">⋮⋮</span>
                                    <img src="{{ $item->image_source ?: 'https://placehold.co/144x104?text=Slide' }}" alt="{{ $item->title }}" class="item-thumb">
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold">{{ $item->title }}</div>
                                        <small class="text-muted">Order saat ini: #{{ $item->order_number }}</small>
                                    </div>
                                    <input type="hidden" name="item_ids[]" value="{{ $item->id }}">
                                </li>
                            @endforeach
                        </ul>

                        <div class="text-end mt-2">
                            <button type="submit" class="btn btn-sm btn-outline-primary">Simpan Urutan</button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                    <tr>
                        <th>Preview</th>
                        <th>Title</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="width: 42%;">Edit Item</th>
                        <th class="text-end">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($slot->items as $item)
                        <tr>
                            <td>
                                @if ($item->image_source)
                                    <img src="{{ $item->image_source }}" alt="{{ $item->title }}" class="item-thumb">
                                @else
                                    <div class="item-thumb d-flex align-items-center justify-content-center text-muted small">No Image</div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $item->title }}</div>
                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($item->description, 80) ?: 'Tanpa deskripsi' }}</small>
                            </td>
                            <td>#{{ $item->order_number }}</td>
                            <td>
                                @if ($item->is_active)
                                    <span class="badge text-bg-success">Aktif</span>
                                @else
                                    <span class="badge text-bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.homepage-slots.items.update', [$slot, $item]) }}" method="POST" enctype="multipart/form-data" class="row g-2">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-12">
                                        <input type="text" name="title" class="form-control form-control-sm" value="{{ $item->title }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" name="order_number" min="1" class="form-control form-control-sm" value="{{ $item->order_number }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="button_text" class="form-control form-control-sm" value="{{ $item->button_text }}" placeholder="Button text">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="link" class="form-control form-control-sm" value="{{ $item->link }}" placeholder="Link tujuan">
                                    </div>
                                    <div class="col-md-8">
                                        <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-center">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $item->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label">Aktif</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input type="url" name="image_url" class="form-control form-control-sm" value="{{ $item->image_url }}" placeholder="https://example.com/image.jpg">
                                    </div>
                                    <div class="col-12">
                                        <textarea name="description" rows="2" class="form-control form-control-sm" placeholder="Deskripsi item">{{ $item->description }}</textarea>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-sm btn-outline-primary">Edit</button>
                                    </div>
                                </form>
                            </td>
                            <td class="text-end">
                                <form action="{{ route('admin.homepage-slots.items.destroy', [$slot, $item]) }}" method="POST" onsubmit="return confirm('Hapus item ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada item untuk slot ini.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const list = document.getElementById('slideSortList');
            if (!list) {
                return;
            }

            let draggingItem = null;

            list.querySelectorAll('.slide-sort-item').forEach(function (item) {
                item.addEventListener('dragstart', function () {
                    draggingItem = item;
                    item.classList.add('dragging');
                });

                item.addEventListener('dragend', function () {
                    item.classList.remove('dragging');
                    draggingItem = null;
                });

                item.addEventListener('dragover', function (event) {
                    event.preventDefault();
                    if (!draggingItem || draggingItem === item) {
                        return;
                    }

                    const rect = item.getBoundingClientRect();
                    const isAfter = (event.clientY - rect.top) > rect.height / 2;
                    if (isAfter) {
                        item.parentNode.insertBefore(draggingItem, item.nextSibling);
                    } else {
                        item.parentNode.insertBefore(draggingItem, item);
                    }
                });
            });

            const sortForm = document.getElementById('slideSortForm');
            if (sortForm) {
                sortForm.addEventListener('submit', function () {
                    const hiddenInputs = sortForm.querySelectorAll('input[name="item_ids[]"]');
                    hiddenInputs.forEach(function (input) {
                        input.remove();
                    });

                    list.querySelectorAll('.slide-sort-item').forEach(function (item) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'item_ids[]';
                        input.value = item.getAttribute('data-item-id') || '';
                        sortForm.appendChild(input);
                    });
                });
            }
        });
    </script>
@endsection
