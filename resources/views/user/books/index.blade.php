@extends('user.layouts.app', ['title' => 'Book List'])

@section('content')
    <style>
        .promo-slots {
            position: relative;
            border-radius: 1.1rem;
            padding: 1rem;
            margin-bottom: 1.15rem;
            background:
                radial-gradient(circle at 8% 0%, rgba(255, 255, 255, 0.12), transparent 34%),
                linear-gradient(135deg, #071731 0%, #0a1f44 42%, #11366d 100%);
            box-shadow: 0 16px 32px rgba(7, 23, 49, 0.25);
        }

        .promo-slots::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 1.1rem;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.06), transparent 40%);
            pointer-events: none;
        }

        .promo-slots-header {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.85rem;
        }

        .promo-heading {
            color: #f5f9ff;
            margin: 0;
            font-size: clamp(1.05rem, 2vw, 1.45rem);
            font-weight: 700;
        }

        .promo-subheading {
            margin: 0.2rem 0 0;
            color: rgba(223, 233, 255, 0.88);
            font-size: 0.88rem;
        }

        .promo-switcher {
            position: relative;
            z-index: 2;
            display: inline-flex;
            gap: 0.45rem;
            padding: 0.25rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.11);
            border: 1px solid rgba(221, 233, 255, 0.3);
        }

        .promo-switch-btn {
            border: 0;
            border-radius: 999px;
            padding: 0.3rem 0.75rem;
            font-size: 0.78rem;
            font-weight: 700;
            color: #d8e6ff;
            background: transparent;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .promo-switch-btn.active {
            background: #f1f6ff;
            color: #0a1f44;
        }

        .promo-stage {
            position: relative;
            z-index: 2;
            border-radius: 1rem;
            overflow: hidden;
            border: 1px solid rgba(171, 196, 237, 0.35);
            background: linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
            box-shadow: 0 12px 24px rgba(10, 31, 68, 0.2);
            margin-top: 0.8rem;
        }

        .promo-stage-inner {
            display: grid;
            grid-template-columns: 300px 1fr;
            min-height: 220px;
        }

        .promo-image-wrap {
            position: relative;
            height: 100%;
            overflow: hidden;
            background: #dfe9fb;
        }

        .promo-image-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.02);
        }

        .promo-badge {
            position: absolute;
            top: 0.65rem;
            left: 0.65rem;
            border-radius: 999px;
            padding: 0.28rem 0.65rem;
            color: #eef5ff;
            font-size: 0.72rem;
            font-weight: 700;
            background: rgba(7, 23, 49, 0.8);
        }

        .promo-body {
            padding: 1rem 1.05rem 1rem;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .promo-title {
            margin: 0;
            font-size: 1.2rem;
            color: #0a1f44;
            font-weight: 700;
            line-height: 1.3;
        }

        .promo-description {
            margin-top: 0.55rem;
            margin-bottom: 0.8rem;
            color: #3d547b;
            font-size: 0.9rem;
            line-height: 1.5;
            max-width: 680px;
        }

        .promo-price {
            margin: 0;
            color: #0e3f8b;
            font-size: 1.12rem;
            font-weight: 700;
        }

        .promo-period {
            margin-top: 0.2rem;
            color: #59739f;
            font-size: 0.78rem;
        }

        .promo-cta {
            margin-top: auto;
            border-radius: 0.62rem;
            border: 1px solid #0d2e61;
            background: #0d2e61;
            color: #fff;
            font-weight: 600;
            padding: 0.45rem 0.75rem;
            text-align: center;
            text-decoration: none;
        }

        .promo-cta:hover {
            background: #123d7f;
            color: #fff;
        }

        .theme-slot-1 .promo-stage {
            background: linear-gradient(180deg, #f8fbff 0%, #ecf3ff 100%);
        }

        .theme-slot-2 .promo-stage {
            background: linear-gradient(180deg, #f4f9ff 0%, #e8f2ff 100%);
        }

        .theme-slot-3 .promo-stage {
            background: linear-gradient(180deg, #f9fbff 0%, #eef5ff 100%);
        }

        .theme-slot-2 .promo-badge {
            background: rgba(15, 50, 97, 0.84);
        }

        .theme-slot-3 .promo-badge {
            background: rgba(7, 37, 79, 0.84);
        }

        @media (max-width: 991px) {
            .promo-stage-inner {
                grid-template-columns: 1fr;
            }

            .promo-image-wrap {
                height: 190px;
            }
        }
    </style>

    @php
        $slotCollection = isset($homepageSlots) ? $homepageSlots : collect();

        $slotDefaults = [
            1 => [
                'title' => "Bundle As I've Written",
                'description' => 'Koleksi novel emosional dengan gaya penceritaan intim untuk pembaca yang suka drama karakter.',
                'price' => 'Rp 149.000',
                'period' => 'Periode Promo: 1 - 30 April 2026',
            ],
            2 => [
                'title' => 'Bundle Demiurge Collection',
                'description' => 'Pilihan judul fantasi gelap dengan world-building kompleks, cocok untuk pembaca epik modern.',
                'price' => 'Rp 189.000',
                'period' => 'Periode Promo: 5 - 30 April 2026',
            ],
            3 => [
                'title' => 'Bundle Special Novel Pack',
                'description' => 'Paket campuran best seller lintas genre untuk hadiah atau koleksi bacaan bulanan.',
                'price' => 'Rp 129.000',
                'period' => 'Periode Promo: 10 - 30 April 2026',
            ],
        ];

        $bookImages = $books->getCollection()
            ->filter(fn ($book) => !empty($book->image_source))
            ->pluck('image_source')
            ->values();

        $promoSlots = collect([1, 2, 3])->map(function ($position) use ($slotCollection, $slotDefaults, $bookImages) {
            $slot = $slotCollection->get($position);
            $fallbackImage = $bookImages->get($position - 1)
                ? $bookImages->get($position - 1)
                : "https://placehold.co/800x520?text=Slot+{$position}";
            $slotTitle = $slot?->title ?: $slotDefaults[$position]['title'];
            $hasCustomLink = !empty($slot?->link);

            return [
                'position' => $position,
                'title' => $slotTitle,
                'description' => $slot?->description ?: $slotDefaults[$position]['description'],
                'price' => $slot?->formatted_price ?: $slotDefaults[$position]['price'],
                'period' => $slotDefaults[$position]['period'],
                'image' => $slot?->image_source ?: $fallbackImage,
                'link' => $hasCustomLink ? $slot->link : route('books.index', ['search' => $slotTitle]),
                'cta' => $hasCustomLink ? 'Lihat Detail Promo' : 'Cari Buku Serupa',
            ];
        });
    @endphp

    @if ($promoSlots->isNotEmpty())
        <section class="promo-slots theme-slot-1" id="promoSlotsSection">
            <div class="promo-slots-header">
                <div>
                    <h2 class="promo-heading">Luxury Promo Bundles</h2>
                    <p class="promo-subheading">Pilih slot promo untuk melihat bundle berbeda, satu tampilan per waktu.</p>
                </div>

                <div class="promo-switcher" role="tablist" aria-label="Pilih slot promo">
                    @foreach ($promoSlots as $slot)
                        <button
                            type="button"
                            class="promo-switch-btn {{ $loop->first ? 'active' : '' }}"
                            data-slot-switch="{{ $slot['position'] }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                        >
                            Slot {{ $slot['position'] }}
                        </button>
                    @endforeach
                </div>
            </div>

            @php
                $firstPromo = $promoSlots->first();
            @endphp

            <div class="promo-stage" id="promoStage">
                <article class="promo-stage-inner">
                    <div class="promo-image-wrap">
                        <img id="promoImage" src="{{ $firstPromo['image'] }}" alt="{{ $firstPromo['title'] }}">
                        <span class="promo-badge" id="promoBadge">Slot {{ $firstPromo['position'] }}</span>
                    </div>

                    <div class="promo-body">
                        <h3 class="promo-title" id="promoTitle">{{ $firstPromo['title'] }}</h3>
                        <p class="promo-description" id="promoDescription">{{ \Illuminate\Support\Str::limit($firstPromo['description'], 170) }}</p>
                        <p class="promo-price" id="promoPrice">{{ $firstPromo['price'] }}</p>
                        <p class="promo-period" id="promoPeriod">{{ $firstPromo['period'] }}</p>
                        <a href="{{ $firstPromo['link'] }}" class="promo-cta" id="promoLink">{{ $firstPromo['cta'] }}</a>
                    </div>
                </article>
            </div>

            <script>
                (() => {
                    const section = document.getElementById('promoSlotsSection');
                    if (!section) return;

                    const slots = @json($promoSlots->values());
                    const buttons = section.querySelectorAll('[data-slot-switch]');

                    const promoImage = document.getElementById('promoImage');
                    const promoBadge = document.getElementById('promoBadge');
                    const promoTitle = document.getElementById('promoTitle');
                    const promoDescription = document.getElementById('promoDescription');
                    const promoPrice = document.getElementById('promoPrice');
                    const promoPeriod = document.getElementById('promoPeriod');
                    const promoLink = document.getElementById('promoLink');

                    const renderSlot = (position) => {
                        const slot = slots.find((item) => Number(item.position) === Number(position));
                        if (!slot) return;

                        promoImage.src = slot.image;
                        promoImage.alt = slot.title;
                        promoBadge.textContent = `Slot ${slot.position}`;
                        promoTitle.textContent = slot.title;
                        promoDescription.textContent = slot.description;
                        promoPrice.textContent = slot.price;
                        promoPeriod.textContent = slot.period;
                        promoLink.href = slot.link;
                        promoLink.textContent = slot.cta;

                        section.classList.remove('theme-slot-1', 'theme-slot-2', 'theme-slot-3');
                        section.classList.add(`theme-slot-${slot.position}`);

                        buttons.forEach((button) => {
                            const isActive = Number(button.dataset.slotSwitch) === Number(slot.position);
                            button.classList.toggle('active', isActive);
                            button.setAttribute('aria-selected', isActive ? 'true' : 'false');
                        });
                    };

                    buttons.forEach((button) => {
                        button.addEventListener('click', () => renderSlot(button.dataset.slotSwitch));
                    });
                })();
            </script>
        </section>
    @endif

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="section-title mb-1">Jelajahi Buku Pilihan</h2>
            <p class="text-muted mb-0">Temukan buku berdasarkan judul, author, atau kategori favorit Anda.</p>
        </div>

        <form method="GET" action="{{ route('books.index') }}" class="row g-2 w-100" role="search" style="max-width: 980px;">
            <div class="col-12 col-lg-4">
                <input type="text" name="search" class="form-control" placeholder="Cari buku atau penulis..." value="{{ $search }}">
            </div>

            <div class="col-6 col-lg-3">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected($selectedCategory === $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-lg-3">
                <select name="author" class="form-select">
                    <option value="">Pilih Penulis</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author }}" @selected(($selectedAuthor ?? '') === $author)>{{ $author }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-lg-2 d-grid d-lg-flex gap-2">
                <button type="submit" class="btn btn-navy w-100">Filter</button>
                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary w-100">Reset Filter</a>
            </div>
        </form>
    </div>

    @if ($categories->isNotEmpty() && empty($selectedAuthor ?? ''))
        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="{{ route('books.index', ['search' => $search ?: null, 'author' => $selectedAuthor ?: null]) }}" class="btn btn-sm {{ $selectedCategory === 0 ? 'btn-navy' : 'btn-outline-secondary' }}">Semua</a>
            @foreach ($categories as $category)
                <a
                    href="{{ route('books.index', ['category' => $category->id, 'search' => $search ?: null, 'author' => $selectedAuthor ?: null]) }}"
                    class="btn btn-sm {{ $selectedCategory === $category->id ? 'btn-navy' : 'btn-outline-secondary' }}"
                >
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    @endif

    <div class="row g-4">
        @forelse ($books as $book)
            <div class="col-md-6 col-lg-3">
                <div class="card card-book h-100">
                    <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none">
                        <img src="{{ $book->image_source ?: 'https://placehold.co/600x800?text=No+Image' }}" class="card-img-top" alt="{{ $book->title }}" style="height: 280px; object-fit: cover;">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <p class="text-muted small mb-2">{{ $book->category?->name ?? 'Tanpa Kategori' }}</p>
                        <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none text-dark">
                            <h5 class="card-title mb-2">{{ $book->title }}</h5>
                        </a>
                        <p class="small text-muted mb-2">{{ $book->author }}</p>
                        <p class="fw-semibold text-primary mb-3">{{ $book->formatted_price }}</p>
                        <div class="mt-auto d-grid gap-2">
                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                            <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-navy w-100">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-center py-4 mb-0">
                    Data buku tidak ditemukan.
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $books->appends(['search' => $search ?: null, 'category' => $selectedCategory ?: null, 'author' => $selectedAuthor ?: null])->links() }}
    </div>
@endsection
