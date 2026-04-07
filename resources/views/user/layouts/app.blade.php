<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Book Market' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #0c1f3f;
            --blue: #1868b7;
            --paper: #f4f7fb;
            --ink: #1f2937;
        }

        html,
        body {
            background: var(--paper);
            color: var(--ink);
            font-family: 'Poppins', sans-serif;
            overscroll-behavior-x: none;
            overflow-x: hidden;
            touch-action: pan-y;
        }

        .container-wide {
            max-width: 1460px;
        }

        .top-utility {
            font-size: 0.86rem;
        }

        .main-header {
            background: #fff;
            border-top: 4px solid var(--navy);
            border-bottom: 1px solid #dbe3ef;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo-box {
            background: #0A1F44;
            width: 58px;
            height: 58px;
            border-radius: 12px;
            box-shadow: 0 8px 18px rgba(10, 31, 68, 0.22);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .brand-logo {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 42% center;
            display: block;
            transform: translateX(-3px) scale(1.38);
        }

        .brand-text {
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            line-height: 1;
        }

        .brand-text .brand-main {
            color: #1f67bf;
        }

        .brand-text .brand-sub {
            color: #0c1f3f;
        }

        .search-pill {
            border-radius: 999px;
            border: 1px solid #cbd5e1;
            overflow: hidden;
            min-height: 48px;
            max-width: 620px;
        }

        .search-pill .form-control,
        .search-pill .input-group-text,
        .search-pill button {
            border: 0;
            box-shadow: none;
            background: #fff;
        }

        .main-nav-link {
            color: #2f3947;
            text-decoration: none;
            font-weight: 500;
            padding: 0.35rem 0.45rem;
            border-radius: 0.5rem;
        }

        .main-nav-link.active,
        .main-nav-link:hover {
            background: #eef3fb;
            color: #173f73;
        }

        .btn-navy {
            background: var(--blue);
            border-color: var(--blue);
            color: #fff;
            border-radius: 0.8rem;
            font-weight: 600;
        }

        .btn-navy:hover {
            background: #105699;
            border-color: #105699;
            color: #fff;
        }

        .section-title {
            color: #0f2a4d;
            letter-spacing: 0.2px;
        }

        @media (max-width: 991px) {
            .search-pill {
                max-width: 100%;
            }

            .brand-logo {
                transform: translateX(-2px) scale(1.34);
            }

            .brand-logo-box {
                width: 52px;
                height: 52px;
                border-radius: 10px;
            }

            .brand-text {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>
<div class="main-header">
    <div class="container container-wide py-2 top-utility d-flex justify-content-end gap-4">
        <a href="{{ route('promo.index') }}" class="link-dark text-decoration-none">Promo</a>
        <a href="{{ route('about') }}" class="link-dark text-decoration-none">Toko Kami</a>
        <a href="{{ route('contact') }}" class="link-dark text-decoration-none">Hubungi Kami</a>
    </div>

    <div class="container container-wide py-3">
        <div class="row align-items-center g-3">
            <div class="col-lg-3 col-md-4">
                <a href="{{ route('landing') }}" class="brand-wrap text-decoration-none">
                    <span class="brand-logo-box">
                        <img src="{{ asset('img/logo 3bie.png') }}" alt="3bieStore Logo" class="brand-logo">
                    </span>
                    <span class="brand-text">
                        <span class="brand-main">3bie</span><span class="brand-sub">Store</span>
                    </span>
                </a>
            </div>

            <div class="col-lg-5 col-md-8">
                <form method="GET" action="{{ route('search') }}" class="input-group search-pill" role="search">
                    <button type="submit" class="input-group-text" style="cursor:pointer;">🔎</button>
                    <input type="text" name="q" class="form-control" placeholder="Cari produk, judul buku, atau penulis" value="{{ request('q', request('search', '')) }}">
                </form>
            </div>

            <div class="col-lg-4 d-flex justify-content-lg-end flex-wrap align-items-center gap-2">
                <a class="main-nav-link {{ request()->routeIs('landing') ? 'active' : '' }}" href="{{ route('landing') }}">Home</a>
                <a class="main-nav-link {{ request()->routeIs('promo.*') ? 'active' : '' }}" href="{{ route('promo.index') }}">Promo</a>
                <a class="main-nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                <a class="main-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                <a class="main-nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">Cart</a>
                <a class="main-nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">Orders</a>
                <a class="main-nav-link {{ request()->routeIs('orders.history') ? 'active' : '' }}" href="{{ route('orders.history') }}">History</a>
                @auth
                    <a class="main-nav-link {{ request()->routeIs('contacts.index') ? 'active' : '' }}" href="{{ route('contacts.index') }}">Pesan Saya</a>
                @endauth
            </div>
        </div>
    </div>
</div>

<main class="py-5">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

@include('user.components.contact-widget')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        // Block horizontal swipe navigation overlay (back/forward gesture) across user pages.
        window.addEventListener('wheel', function (event) {
            if (Math.abs(event.deltaX) <= Math.abs(event.deltaY)) {
                return;
            }

            const allowHorizontal = event.target.closest('[data-scroll-container], [data-slider-track]');
            if (allowHorizontal) {
                return;
            }

            event.preventDefault();
        }, { passive: false });

        let touchStartX = 0;
        let touchStartY = 0;

        window.addEventListener('touchstart', function (event) {
            if (!event.touches || event.touches.length === 0) {
                return;
            }

            touchStartX = event.touches[0].clientX;
            touchStartY = event.touches[0].clientY;
        }, { passive: true });

        window.addEventListener('touchmove', function (event) {
            if (!event.touches || event.touches.length === 0) {
                return;
            }

            const dx = event.touches[0].clientX - touchStartX;
            const dy = event.touches[0].clientY - touchStartY;
            const isHorizontalSwipe = Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 10;

            if (!isHorizontalSwipe) {
                return;
            }

            const allowHorizontal = event.target.closest('[data-scroll-container], [data-slider-track]');
            if (allowHorizontal) {
                return;
            }

            event.preventDefault();
        }, { passive: false });
    })();
</script>
</body>
</html>
