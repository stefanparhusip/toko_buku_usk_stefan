@extends('user.layouts.app', ['title' => 'Promo'])

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">Promo Menarik Untuk Kamu</h2>
            <p class="text-muted mb-0">Nikmati promo aktif yang sedang berlangsung di 3bieStore.</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse ($promos as $promo)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                    <img
                        src="{{ $promo->image ? asset('storage/' . $promo->image) : 'https://placehold.co/1200x700?text=Promo+Banner' }}"
                        alt="{{ $promo->title }}"
                        class="w-100"
                        style="height: 220px; object-fit: cover;"
                    >

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            @if ($promo->discount)
                                <span class="badge text-bg-primary">Diskon {{ $promo->discount }}%</span>
                                @if ($promo->discount >= 30)
                                    <span class="badge text-bg-warning">Promo Populer</span>
                                @endif
                            @endif
                        </div>

                        <h5 class="card-title mb-2">{{ $promo->title }}</h5>
                        <p class="text-muted mb-3">{{ \Illuminate\Support\Str::limit($promo->description, 120) }}</p>

                        @if ($promo->start_date || $promo->end_date)
                            <p class="small text-muted mb-3">
                                Berlaku:
                                {{ $promo->start_date ? $promo->start_date->format('d M Y') : '-' }}
                                -
                                {{ $promo->end_date ? $promo->end_date->format('d M Y') : '-' }}
                            </p>
                        @endif

                        <div class="mt-auto d-grid gap-2">
                            <button
                                type="button"
                                class="btn btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#promoDetail{{ $promo->id }}"
                            >
                                Lihat Detail
                            </button>
                            <a href="{{ route('books.index') }}" class="btn btn-navy">Gunakan Promo</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="promoDetail{{ $promo->id }}" tabindex="-1" aria-labelledby="promoDetailLabel{{ $promo->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content border-0 rounded-4 overflow-hidden">
                        <img
                            src="{{ $promo->image ? asset('storage/' . $promo->image) : 'https://placehold.co/1200x700?text=Promo+Banner' }}"
                            alt="{{ $promo->title }}"
                            class="w-100"
                            style="height: 260px; object-fit: cover;"
                        >
                        <div class="modal-body p-4">
                            <h5 id="promoDetailLabel{{ $promo->id }}" class="mb-2">{{ $promo->title }}</h5>
                            <p class="text-muted mb-3">{{ $promo->description }}</p>

                            @if ($promo->discount)
                                <div class="mb-2">
                                    <span class="badge text-bg-primary">Diskon {{ $promo->discount }}%</span>
                                </div>
                            @endif

                            @if ($promo->start_date || $promo->end_date)
                                <p class="small text-muted mb-0">
                                    Berlaku:
                                    {{ $promo->start_date ? $promo->start_date->format('d M Y') : '-' }}
                                    -
                                    {{ $promo->end_date ? $promo->end_date->format('d M Y') : '-' }}
                                </p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="{{ route('books.index') }}" class="btn btn-navy">Gunakan Promo</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-center py-4 mb-0">Belum ada promo tersedia</div>
            </div>
        @endforelse
    </div>

    @if ($promos->hasPages())
        <div class="mt-4">
            {{ $promos->links() }}
        </div>
    @endif
@endsection
