@extends('admin.layouts.app', ['title' => 'Homepage Slots'])

@section('content')
    <style>
        .slot-preview-shell {
            border: 1px solid #d7e3f5;
            border-radius: 1rem;
            background: linear-gradient(170deg, #f9fbff, #f3f7ff);
            padding: 1rem;
        }

        .slot-block {
            position: relative;
            border: 2px dashed #aec6ea;
            border-radius: 0.9rem;
            background: #fff;
            overflow: hidden;
            min-height: 150px;
        }

        .slot-block.hero {
            min-height: 320px;
        }

        .slot-block.banner {
            min-height: 152px;
        }

        .slot-block.book {
            min-height: 260px;
        }

        .slot-tag {
            position: absolute;
            top: 0.55rem;
            left: 0.55rem;
            background: rgba(10, 31, 68, 0.9);
            color: #fff;
            border-radius: 0.55rem;
            padding: 0.2rem 0.48rem;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 2;
        }

        .slot-edit-btn {
            position: absolute;
            top: 0.55rem;
            right: 0.55rem;
            z-index: 2;
        }

        .slot-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .slot-empty {
            height: 100%;
            min-height: inherit;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6e7e9d;
            background: repeating-linear-gradient(45deg, #f2f6ff, #f2f6ff 14px, #e8f0ff 14px, #e8f0ff 28px);
            text-align: center;
            padding: 1rem;
            font-size: 0.92rem;
        }

        .slot-overlay {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 1rem 0.9rem 0.8rem;
            background: linear-gradient(180deg, rgba(10, 31, 68, 0.02) 0%, rgba(10, 31, 68, 0.88) 100%);
            color: #fff;
        }

        .slot-overlay small {
            display: block;
            color: rgba(255, 255, 255, 0.78);
        }

        .slot-inactive {
            opacity: 0.58;
            filter: grayscale(0.25);
        }

        .slot-table-thumb {
            width: 68px;
            height: 46px;
            border-radius: 0.55rem;
            border: 1px solid #d7e3f5;
            object-fit: cover;
            background: #eef3fd;
        }

        .slot-slider-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.8rem;
        }

        .slot-slider-controls {
            display: inline-flex;
            gap: 0.45rem;
        }

        .slot-slider-btn {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: 1px solid #c9d8ef;
            background: #fff;
            color: #284c7d;
            font-size: 1rem;
            line-height: 1;
            font-weight: 700;
        }

        .slot-slider-btn:hover {
            background: #f3f8ff;
        }

        .slot-slider-track {
            display: flex;
            gap: 0.85rem;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 0.25rem;
            scrollbar-width: thin;
        }

        .slot-slider-item {
            flex: 0 0 clamp(220px, 24vw, 300px);
        }

        .slot-slider-item .slot-block {
            min-height: 240px;
        }

        .slot-slider-track::-webkit-scrollbar {
            height: 8px;
        }

        .slot-slider-track::-webkit-scrollbar-thumb {
            background: #c6d8f3;
            border-radius: 999px;
        }
    </style>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">Pengaturan Homepage Berbasis Slot</h3>
            <p class="text-muted mb-0">Kelola konten hero, banner, dan list buku homepage berdasarkan posisi slot.</p>
        </div>
    </div>

    <div class="card card-elegant mb-4">
        <div class="card-body">
            <h5 class="mb-3">Preview Layout Homepage</h5>
            <div class="slot-preview-shell">
                <div class="row g-3">
                    @php
                        $hero = $slotsByPosition->get(1);
                        $bannerTop = $slotsByPosition->get(2);
                        $bannerBottom = $slotsByPosition->get(3);
                    @endphp

                    <div class="col-lg-8">
                        @include('admin.homepage-slots.partials.slot-preview-block', ['slot' => $hero, 'class' => 'hero'])
                    </div>
                    <div class="col-lg-4 d-flex flex-column gap-3">
                        @include('admin.homepage-slots.partials.slot-preview-block', ['slot' => $bannerTop, 'class' => 'banner'])
                        @include('admin.homepage-slots.partials.slot-preview-block', ['slot' => $bannerBottom, 'class' => 'banner'])
                    </div>

                    @foreach (range(4, 10) as $position)
                        <div class="col-xl col-lg-3 col-md-4 col-6">
                            @include('admin.homepage-slots.partials.slot-preview-block', [
                                'slot' => $slotsByPosition->get($position),
                                'class' => 'book',
                                'slotTag' => 'Slot '.($position - 3),
                            ])
                        </div>
                    @endforeach
                </div>
            </div>

            <hr class="my-4">

            <div class="slot-slider-head">
                <div>
                    <h6 class="mb-1">Slider Slot Kecil (1-7)</h6>
                    <p class="text-muted small mb-0">Khusus slot kecil di bawah, penomoran dimulai ulang dari 1 sampai 7.</p>
                </div>
                <div class="slot-slider-controls">
                    <button type="button" class="slot-slider-btn" id="slotSliderPrev" aria-label="Geser kiri">&#8249;</button>
                    <button type="button" class="slot-slider-btn" id="slotSliderNext" aria-label="Geser kanan">&#8250;</button>
                </div>
            </div>

            <div class="slot-slider-track" id="slotSliderTrack">
                @foreach (range(4, 10) as $position)
                    <div class="slot-slider-item">
                        @include('admin.homepage-slots.partials.slot-preview-block', [
                            'slot' => $slotsByPosition->get($position),
                            'class' => 'book',
                            'slotTag' => 'Slot '.($position - 3),
                        ])
                    </div>
                @endforeach
            </div>

            <script>
                (() => {
                    const track = document.getElementById('slotSliderTrack');
                    const prev = document.getElementById('slotSliderPrev');
                    const next = document.getElementById('slotSliderNext');
                    if (!track || !prev || !next) return;

                    const step = () => Math.max(260, Math.floor(track.clientWidth * 0.8));

                    prev.addEventListener('click', () => {
                        track.scrollBy({ left: -step(), behavior: 'smooth' });
                    });

                    next.addEventListener('click', () => {
                        track.scrollBy({ left: step(), behavior: 'smooth' });
                    });
                })();
            </script>
        </div>
    </div>

    <div class="card card-elegant">
        <div class="card-body">
            <h5 class="mb-3">Daftar Slot</h5>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th>Slot</th>
                        <th>Preview</th>
                        <th>Title</th>
                        <th>Tipe</th>
                        <th>Status</th>
                        <th>Buku</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($slots as $slot)
                        <tr>
                            <td class="fw-semibold">#{{ $slot->position }}</td>
                            <td>
                                @if ($slot->image_source)
                                    <img src="{{ $slot->image_source }}" alt="Slot {{ $slot->position }}" class="slot-table-thumb">
                                @else
                                    <div class="slot-table-thumb d-flex align-items-center justify-content-center text-muted small">No Image</div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $slot->title }}</div>
                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($slot->description, 60) ?: 'Tanpa deskripsi' }}</small>
                            </td>
                            <td><span class="badge text-bg-light border text-capitalize">{{ $slot->type }}</span></td>
                            <td>
                                @if ($slot->is_active)
                                    <span class="badge text-bg-success">Aktif</span>
                                @else
                                    <span class="badge text-bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>{{ $slot->book?->title ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.homepage-slots.edit', $slot) }}" class="btn btn-sm btn-outline-primary">Edit Slot</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
