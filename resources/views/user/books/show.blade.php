@extends('user.layouts.app', ['title' => 'Book Detail'])

@section('content')
    <style>
        .detail-shell {
            background: linear-gradient(180deg, #f6f9ff 0%, #eef4ff 100%);
            border-radius: 1.2rem;
            border: 1px solid #d9e4f6;
            padding: 1rem;
        }

        .bundle-banner {
            position: relative;
            border-radius: 1.2rem;
            overflow: hidden;
            background:
                radial-gradient(circle at 90% 30%, rgba(105, 157, 255, 0.3), transparent 32%),
                linear-gradient(122deg, #0a1f44 0%, #123a74 52%, #0b2a58 100%);
            color: #f8fbff;
            box-shadow: 0 16px 30px rgba(10, 31, 68, 0.25);
            min-height: 250px;
        }

        .bundle-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 10% 20%, rgba(137, 184, 255, 0.18), transparent 45%);
            pointer-events: none;
        }

        .bundle-content {
            position: relative;
            z-index: 2;
            padding: 1.5rem 1.4rem;
        }

        .promo-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border-radius: 999px;
            padding: 0.32rem 0.75rem;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.28);
            font-weight: 600;
            font-size: 0.8rem;
        }

        .banner-title {
            font-size: clamp(1.35rem, 2.5vw, 2rem);
            line-height: 1.12;
            font-weight: 700;
            margin: 0.75rem 0 0.4rem;
        }

        .banner-subtitle {
            color: rgba(235, 243, 255, 0.88);
            margin-bottom: 0.75rem;
            max-width: 520px;
        }

        .banner-price {
            font-size: clamp(1.25rem, 2.2vw, 1.75rem);
            font-weight: 700;
            color: #ffe18b;
            margin-bottom: 0.1rem;
        }

        .banner-period {
            color: rgba(220, 232, 255, 0.88);
            font-size: 0.86rem;
            margin-bottom: 0.8rem;
        }

        .btn-terms {
            border-radius: 0.65rem;
            border: 1px solid rgba(255, 255, 255, 0.6);
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            font-weight: 600;
            padding: 0.5rem 0.9rem;
        }

        .btn-terms:hover {
            color: #0a1f44;
            background: #fff;
        }

        .bundle-art {
            position: relative;
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
        }

        .bundle-main {
            width: 215px;
            height: 215px;
            border-radius: 0.9rem;
            object-fit: cover;
            box-shadow: 0 12px 28px rgba(5, 17, 40, 0.44);
            border: 1px solid rgba(255, 255, 255, 0.22);
        }

        .bundle-side {
            position: absolute;
            width: 112px;
            height: 152px;
            border-radius: 0.7rem;
            object-fit: cover;
            border: 1px solid rgba(255, 255, 255, 0.22);
            box-shadow: 0 10px 22px rgba(6, 18, 42, 0.4);
            background: #fff;
        }

        .side-left {
            left: 4%;
            top: 18%;
            transform: rotate(-9deg);
        }

        .side-right {
            right: 4%;
            top: 18%;
            transform: rotate(8deg);
        }

        .detail-grid {
            margin-top: 0.95rem;
            border: 1px solid #d7e1f2;
            background: rgba(255, 255, 255, 0.86);
            border-radius: 1rem;
            padding: 1.2rem;
        }

        .detail-header {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .detail-title {
            font-size: clamp(1.3rem, 2vw, 1.8rem);
            font-weight: 700;
            color: #0d2a56;
            margin: 0;
        }

        .filter-panel {
            border: 1px solid #dbe5f4;
            border-radius: 0.95rem;
            padding: 1rem;
            background: #fff;
        }

        .chip {
            border: 1px solid #c8d5eb;
            border-radius: 999px;
            padding: 0.38rem 0.8rem;
            background: #f4f8ff;
            font-size: 0.87rem;
            color: #234775;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.95rem;
        }

        .product-preview {
            border: 1px solid #dce6f5;
            border-radius: 0.95rem;
            background: #fff;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(19, 55, 108, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            flex-direction: column;
        }

        .product-preview:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 34px rgba(19, 55, 108, 0.16);
        }

        .preview-image {
            width: 100%;
            height: 190px;
            object-fit: cover;
        }

        .meta-item {
            border: 1px solid #dde6f5;
            border-radius: 0.85rem;
            padding: 0.7rem;
            background: #f8fbff;
        }

        @media (max-width: 991px) {
            .bundle-content {
                padding: 1.15rem;
            }

            .bundle-art {
                min-height: 200px;
                padding-top: 0;
            }

            .bundle-main {
                width: 165px;
                height: 165px;
            }

            .bundle-side {
                width: 66px;
                height: 94px;
            }

            .catalog-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="mb-3 d-flex align-items-center justify-content-between">
        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">&larr; Kembali ke Daftar</a>
    </div>

    <section class="detail-shell">
        @php
            $slotHero = $homepageSlots->get(1);
            $slotBannerTop = $homepageSlots->get(2);
            $slotBannerBottom = $homepageSlots->get(3);

            // Keep each slot independent: slot 2/3 must not reuse slot 1 image when empty.
            $leftImage = $slotHero?->image_source
                ? $slotHero->image_source
                : 'https://placehold.co/600x800?text=Slot+1';
            $centerImage = $slotBannerTop?->image_source
                ? $slotBannerTop->image_source
                : 'https://placehold.co/600x800?text=Slot+2';
            $rightImage = $slotBannerBottom?->image_source
                ? $slotBannerBottom->image_source
                : 'https://placehold.co/600x800?text=Slot+3';
        @endphp

        <div class="bundle-banner">
            <div class="row g-0 align-items-stretch">
                <div class="col-lg-7">
                    <div class="bundle-content">
                        <span class="promo-pill">Special Offer</span>
                        <h1 class="banner-title">{{ $slotHero?->title ?: $book->title }}</h1>
                        <p class="banner-subtitle">{{ \Illuminate\Support\Str::limit($slotHero?->description ?: 'Promo bundle eksklusif untuk pengalaman belanja modern.', 140) }}</p>
                        <div class="banner-price">{{ $book->formatted_price }}</div>
                        <div class="banner-period">Periode Promo: 1 - 30 April 2026</div>
                        <button type="button" class="btn btn-terms">Terms & Conditions</button>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="bundle-art">
                        <img src="{{ $centerImage }}" alt="{{ $slotBannerTop?->title ?: $book->title }}" class="bundle-main">
                        <img src="{{ $leftImage }}" alt="{{ $slotHero?->title ?: 'Slot 1' }}" class="bundle-side side-left">
                        <img src="{{ $rightImage }}" alt="{{ $slotBannerBottom?->title ?: 'Slot 3' }}" class="bundle-side side-right">
                    </div>
                </div>
            </div>
        </div>

        <div class="detail-grid">
            <div class="detail-header">
                <div>
                    <h2 class="detail-title">{{ $book->title }}</h2>
                    <p class="text-muted mb-0">Judul produk dinamis, dapat disesuaikan dari admin panel.</p>
                </div>
            </div>

            @if (!empty($focusDetail))
                <div class="row g-3">
                    <div class="col-lg-5">
                        <img src="{{ $book->image_source ?: 'https://placehold.co/640x860?text=Book' }}" alt="{{ $book->title }}" class="w-100 rounded-3" style="max-height: 520px; object-fit: cover; border: 1px solid #dde6f5;">
                    </div>
                    <div class="col-lg-7">
                        <div class="meta-item mb-2"><strong>Judul:</strong> {{ $book->title }}</div>
                        <div class="meta-item mb-2"><strong>Kategori:</strong> {{ $book->category?->name ?? '-' }}</div>
                        <div class="meta-item mb-2"><strong>Author:</strong> {{ $book->author }}</div>
                        <div class="meta-item mb-2"><strong>Penerbit:</strong> {{ $book->publisher }}</div>
                        <div class="meta-item mb-2"><strong>Tahun:</strong> {{ $book->year }}</div>
                        <div class="meta-item mb-2"><strong>Harga:</strong> {{ $book->formatted_price }}</div>
                        <div class="meta-item mb-2"><strong>Stok:</strong> {{ $book->stock }}</div>
                        <div class="meta-item"><strong>Deskripsi:</strong><br>{{ $book->description }}</div>

                        <div class="mt-3 d-flex gap-2 flex-wrap">
                            @if ($book->stock > 0)
                                <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-navy">Add to Cart</button>
                                </form>
                            @endif
                            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Lihat Buku Lain</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="row g-3">
                    <div class="col-lg-4">
                        <div class="filter-panel">
                            <h6 class="fw-semibold mb-3">Filter</h6>
                            <form method="GET" action="{{ route('books.show', $book->id) }}" class="d-grid gap-3">
                                <div>
                                    <label class="form-label small text-muted">Cari Produk</label>
                                    <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Judul atau penulis">
                                </div>

                                <div>
                                    <label class="form-label small text-muted">Kategori</label>
                                    <select name="category" class="form-select">
                                        <option value="0">Semua kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $selectedCategory === (int) $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="form-label small text-muted">Urutkan</label>
                                    <select name="sort" class="form-select">
                                        <option value="newest" {{ $selectedSort === 'newest' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="price_low" {{ $selectedSort === 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                        <option value="price_high" {{ $selectedSort === 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                    </select>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="inStockOnly" name="in_stock" value="1" {{ $inStockOnly ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inStockOnly">Hanya tampilkan stok tersedia</label>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-navy">Terapkan</button>
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-outline-secondary">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        @if ($relatedBooks->isEmpty())
                            <div class="alert alert-light border">Tidak ada produk yang sesuai filter.</div>
                        @else
                            <div class="catalog-grid">
                                @foreach ($relatedBooks as $item)
                                    <article class="product-preview">
                                        <img src="{{ $item->image_source ?: 'https://placehold.co/640x420?text=Product' }}" alt="{{ $item->title }}" class="preview-image">
                                        <div class="p-3 d-flex flex-column h-100">
                                            <small class="text-muted">{{ $item->category?->name ?? 'Produk' }}</small>
                                            <h6 class="mt-1 mb-1">{{ \Illuminate\Support\Str::limit($item->title, 54) }}</h6>
                                            <div class="fw-bold text-primary mb-2">{{ $item->formatted_price }}</div>
                                            <div class="mt-auto d-grid gap-2">
                                                <a href="{{ route('books.show', $item->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                                @if ($item->stock > 0)
                                                    <form action="{{ route('cart.add', $item->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-navy w-100">Add to Cart</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>

                            <div class="mt-3">
                                {{ $relatedBooks->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
