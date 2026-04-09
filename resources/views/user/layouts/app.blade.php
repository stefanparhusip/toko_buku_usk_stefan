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
            --navy-900: #0f172a;
            --navy-800: #1e2b4b;
            --navy-100: #e8eefc;
            --paper: #f4f7fb;
            --ink: #1f2937;
            --line: #d8e2f0;
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

        .main-header {
            background: rgba(255, 255, 255, 0.98);
            border-bottom: 1px solid var(--line);
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
            position: sticky;
            top: 0;
            z-index: 1020;
            backdrop-filter: blur(8px);
        }

        .header-main {
            min-height: 74px;
            display: grid;
            grid-template-columns: auto minmax(280px, 1fr) auto;
            gap: 1rem;
            align-items: center;
            padding: 0.55rem 0;
        }

        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
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

        .header-search {
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
        }

        .header-search-wrap {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            width: 100%;
            max-width: 760px;
            margin: 0 auto;
        }

        .btn-category {
            border-radius: 999px;
            min-height: 48px;
            padding-inline: 0.95rem;
            white-space: nowrap;
            border-color: #c9d6ea;
            color: #0f172a;
            background: #f7faff;
        }

        .btn-category:hover {
            background: #edf3ff;
            border-color: #b8caea;
            color: #0f172a;
        }

        .category-menu {
            border-radius: 12px;
            border: 1px solid #d7e2f2;
            box-shadow: 0 12px 26px rgba(15, 23, 42, 0.12);
            padding: 0.35rem;
            max-height: 320px;
            overflow-y: auto;
        }

        .category-menu .dropdown-item {
            border-radius: 8px;
            font-size: 0.9rem;
            padding: 0.45rem 0.62rem;
        }

        .category-menu .dropdown-item:hover {
            background: #eef3ff;
            color: #0f172a;
        }

        .search-pill {
            border-radius: 999px;
            border: 1px solid #c9d6ea;
            overflow: hidden;
            min-height: 48px;
            background: #fff;
        }

        .search-pill .form-control,
        .search-pill .input-group-text,
        .search-pill button {
            border: 0;
            box-shadow: none;
            background: #fff;
        }

        .search-pill .form-control {
            font-size: 0.95rem;
        }

        .auth-actions {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .auth-chip {
            color: #4b5b76;
            font-size: 0.82rem;
            margin-right: 0.1rem;
            white-space: nowrap;
        }

        .main-nav-wrap {
            border-top: 1px solid #eef3fb;
        }

        .main-nav {
            padding: 0.3rem 0 0.55rem;
        }

        .main-nav-list {
            gap: 0.2rem;
        }

        .main-nav-link {
            position: relative;
            color: #2f3947;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 0.68rem;
            border-radius: 0.6rem;
            transition: color 0.2s ease, background-color 0.2s ease;
        }

        .main-nav-link::after {
            content: '';
            position: absolute;
            left: 0.68rem;
            right: 0.68rem;
            bottom: 0.28rem;
            height: 2px;
            border-radius: 2px;
            background: var(--navy-900);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.2s ease;
        }

        .main-nav-link:hover {
            color: var(--navy-900);
            background: #eef3fb;
        }

        .main-nav-link:hover::after,
        .main-nav-link.active::after {
            transform: scaleX(1);
        }

        .main-nav-link.active {
            color: var(--navy-900);
            font-weight: 600;
            background: #eef3fb;
        }

        .menu-toggler {
            border: 1px solid #ccd8ee;
            border-radius: 0.7rem;
            padding: 0.45rem 0.65rem;
        }

        .menu-toggler .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2815,23,42,0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .menu-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(15, 23, 42, 0.12);
        }

        .btn {
            border-radius: 11px;
            font-weight: 600;
            padding: 0.5rem 1rem;
            transition: all 0.22s ease;
        }

        .btn-sm {
            border-radius: 10px;
            padding: 0.38rem 0.78rem;
        }

        .btn-primary,
        .btn-navy {
            background: var(--navy-900);
            border-color: var(--navy-900);
            color: #fff;
        }

        .btn-primary:hover,
        .btn-navy:hover {
            background: var(--navy-800);
            border-color: var(--navy-800);
            color: #fff;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.18);
        }

        .btn-secondary,
        .btn-light {
            background: #f5f8ff;
            border: 1px solid #b9c9e8;
            color: var(--navy-900);
        }

        .btn-secondary:hover,
        .btn-light:hover {
            background: #eaf1ff;
            border-color: #a7bce3;
            color: var(--navy-900);
        }

        .btn-outline-primary,
        .btn-outline-secondary {
            background: transparent;
            border-color: var(--navy-900);
            color: var(--navy-900);
        }

        .btn-outline-primary:hover,
        .btn-outline-secondary:hover {
            background: var(--navy-900);
            border-color: var(--navy-900);
            color: #fff;
        }

        .btn-outline-danger {
            border-radius: 10px;
        }

        .badge.bg-purple {
            background-color: #7c3aed !important;
        }

        .badge.bg-orange {
            background-color: #f97316 !important;
        }

        .section-title {
            color: #0f2a4d;
            letter-spacing: 0.2px;
        }

        @media (max-width: 991px) {
            .header-main {
                grid-template-columns: auto 1fr auto;
                min-height: 68px;
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
                font-size: 1.08rem;
            }

            .main-nav {
                padding-top: 0.25rem;
            }

            .header-search-wrap {
                max-width: 100%;
            }

            .main-nav-list {
                padding-top: 0.4rem;
                gap: 0.1rem;
            }

            .auth-actions-mobile {
                border-top: 1px solid #edf2fb;
                margin-top: 0.7rem;
                padding-top: 0.7rem;
            }
        }
    </style>
</head>
<body>
@php
    $headerCategories = $headerCategories ?? collect();
@endphp
<div class="main-header">
    <div class="container container-wide">
        <div class="header-main">
            <a href="{{ route('landing') }}" class="brand-wrap">
                <span class="brand-logo-box">
                    <img src="{{ asset('img/logo 3bie.png') }}" alt="3bieStore Logo" class="brand-logo">
                </span>
                <span class="brand-text">
                    <span class="brand-main">3bie</span><span class="brand-sub">Store</span>
                </span>
            </a>

            <div class="header-search-wrap d-none d-md-flex">
                <div class="dropdown">
                    <button class="btn btn-light btn-category dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori
                    </button>
                    <ul class="dropdown-menu category-menu">
                        <li><a class="dropdown-item" href="{{ route('books.index') }}">Semua Kategori</a></li>
                        @foreach ($headerCategories as $category)
                            <li><a class="dropdown-item" href="{{ route('categories.books', $category->id) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <form method="GET" action="{{ route('search') }}" class="input-group search-pill header-search" role="search">
                    <button type="submit" class="input-group-text" aria-label="Cari">🔎</button>
                    <input type="text" name="q" class="form-control" placeholder="Cari produk, judul buku, atau penulis" value="{{ request('q', request('search', '')) }}">
                </form>
            </div>

            <div class="auth-actions d-none d-lg-inline-flex">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                @else
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">Akun</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Keluar</button>
                    </form>
                @endguest
            </div>

            <button class="navbar-toggler menu-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarMenu" aria-controls="mainNavbarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="header-search-wrap d-md-none mb-2">
            <div class="dropdown">
                <button class="btn btn-light btn-category dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Kategori
                </button>
                <ul class="dropdown-menu category-menu">
                    <li><a class="dropdown-item" href="{{ route('books.index') }}">Semua Kategori</a></li>
                    @foreach ($headerCategories as $category)
                        <li><a class="dropdown-item" href="{{ route('categories.books', $category->id) }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <form method="GET" action="{{ route('search') }}" class="input-group search-pill" role="search">
                <button type="submit" class="input-group-text" aria-label="Cari">🔎</button>
                <input type="text" name="q" class="form-control" placeholder="Cari produk, judul buku, atau penulis" value="{{ request('q', request('search', '')) }}">
            </form>
        </div>

        <div class="main-nav-wrap">
            <nav class="navbar navbar-expand-lg main-nav">
                <div class="collapse navbar-collapse" id="mainNavbarMenu">
                    <div class="navbar-nav main-nav-list">
                        <a class="main-nav-link {{ request()->routeIs('landing') ? 'active' : '' }}" href="{{ route('landing') }}">Home</a>
                        <a class="main-nav-link {{ request()->routeIs('promo.*') ? 'active' : '' }}" href="{{ route('promo.index') }}">Promo</a>
                        <a class="main-nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                        <a class="main-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                        <a class="main-nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }}" href="{{ route('cart.index') }}">Cart</a>
                        <a class="main-nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}" href="{{ route('orders.index') }}">Orders</a>
                        <a class="main-nav-link {{ request()->routeIs('orders.history') ? 'active' : '' }}" href="{{ route('orders.history') }}">History</a>
                        @auth
                            <a class="main-nav-link {{ request()->routeIs('chat.*') ? 'active' : '' }}" href="{{ route('chat.index') }}">Chat Admin</a>
                            <a class="main-nav-link {{ request()->routeIs('contacts.index') ? 'active' : '' }}" href="{{ route('contacts.index') }}">Pesan Saya</a>
                        @endauth
                    </div>

                    <div class="auth-actions auth-actions-mobile d-lg-none w-100">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary">Masuk</a>
                            <a href="{{ route('register') }}" class="btn btn-primary">Daftar</a>
                        @else
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">Akun</a>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary">Keluar</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </nav>
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
