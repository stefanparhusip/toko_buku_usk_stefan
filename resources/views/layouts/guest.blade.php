<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $attributes->get('pageTitle', config('app.name', 'Book Market')) }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --ink: #252733;
            --muted: #80889a;
            --border: #d9dde6;
            --brand: #1f5fae;
        }

        body {
            background: #f7f8fb;
            color: var(--ink);
            font-family: 'Poppins', sans-serif;
        }

        .auth-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr;
        }

        .panel-left {
            background: #f4f6fb;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
        }

        .panel-right {
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .left-content {
            width: 100%;
            max-width: 540px;
            text-align: center;
        }

        .brand-title {
            color: var(--brand);
            font-weight: 700;
            font-size: 2rem;
        }

        .brand-logo {
            height: 58px;
            width: auto;
            max-width: 280px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        .illustration {
            border-radius: 1.25rem;
            background: #eef2f8;
            border: 1px solid #dde5f2;
            min-height: 340px;
            position: relative;
            overflow: hidden;
            margin: 1.5rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .decor-image {
            width: 100%;
            max-width: 460px;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .social-row {
            color: var(--muted);
            font-size: 0.9rem;
        }

        .social-badge {
            width: 34px;
            height: 34px;
            border-radius: 0.55rem;
            display: grid;
            place-items: center;
            border: 1px solid #ccd3e0;
            background: #fff;
            font-weight: 600;
        }

        .form-wrap {
            width: 100%;
            max-width: 620px;
        }

        .auth-title {
            font-weight: 700;
            margin-bottom: 1.7rem;
            text-align: center;
            font-size: clamp(1.6rem, 2.2vw, 2.7rem);
            color: #0f223f;
        }

        .form-control {
            min-height: 54px;
            border-radius: 0.9rem;
            border-color: var(--border);
        }

        .form-control:focus {
            border-color: #a5b4cf;
            box-shadow: 0 0 0 0.2rem rgba(31, 95, 174, 0.12);
        }

        .btn-auth {
            min-height: 54px;
            border-radius: 0.95rem;
            font-weight: 600;
            background: #cfd3da;
            border-color: #cfd3da;
            color: #fff;
            font-size: 1.05rem;
        }

        .btn-auth:hover {
            background: #bfc5cf;
            border-color: #bfc5cf;
            color: #fff;
        }

        .muted-link {
            color: #2a2f39;
        }

        @media (min-width: 992px) {
            .auth-shell {
                grid-template-columns: 1fr 1fr;
            }

            .panel-left {
                display: flex;
                padding: 3rem 2.8rem;
            }

            .panel-right {
                padding: 2.8rem 3.1rem;
            }
        }

        @media (max-width: 991px) {
            .auth-title {
                font-size: 1.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-shell">
        <aside class="panel-left">
            <div class="left-content">
                <img src="{{ asset('img/logo-3bie.png') }}" alt="Book Market Logo" class="brand-logo">

                <div class="illustration">
                    <img
                        src="{{ asset('img/ilustrasi-auth.webp') }}"
                        alt="Ilustrasi Membaca Buku"
                        class="decor-image"
                        onerror="this.style.display='none'; this.parentElement.insertAdjacentHTML('beforeend','<div class=\"text-muted small\">Ilustrasi belum tersedia</div>');"
                    >
                </div>

                <div class="social-row">
                    <div class="d-flex justify-content-center gap-2 mb-2">
                        <span class="social-badge">f</span>
                        <span class="social-badge">x</span>
                        <span class="social-badge">i</span>
                        <span class="social-badge">t</span>
                    </div>
                    <div>customercare@bookmarket.app</div>
                    <div class="mt-1">© 2026 Book Market App</div>
                </div>
            </div>
        </aside>

        <main class="panel-right">
            <div class="form-wrap">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <h2 class="auth-title">{{ $attributes->get('heading', 'Masuk Akun') }}</h2>

                <div class="card border-0 bg-transparent">
                    <div class="card-body p-0">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
