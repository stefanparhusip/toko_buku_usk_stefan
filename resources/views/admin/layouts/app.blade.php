<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Book Market' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #0A1F44;
            --navy-soft: #12305f;
            --ink: #1f2b3d;
            --muted: #6f7b91;
            --soft-bg: #f2f6fc;
            --card: #ffffff;
            --line: #dbe5f3;
            --accent: #1d75d2;
            --success: #1f9d65;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: radial-gradient(circle at 25% 0%, #f8fbff 0%, #f0f4fb 56%, #eef3fa 100%);
            color: var(--ink);
            font-family: 'Poppins', sans-serif;
        }

        .admin-shell {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        .admin-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            background: linear-gradient(180deg, #0c244f 0%, #0A1F44 55%, #081a39 100%);
            color: #fff;
            padding: 1.25rem 1rem;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.35rem 0.4rem;
        }

        .brand-logo-box {
            width: 50px;
            height: 50px;
            border-radius: 11px;
            background: #081733;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        }

        .brand-logo-mini {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 42% center;
            transform: translateX(-2px) scale(1.34);
        }

        .brand-text-side {
            color: #fff;
            font-weight: 600;
            letter-spacing: 0.25px;
            font-size: 1.02rem;
        }

        .sidebar-nav {
            gap: 0.35rem;
        }

        .sidebar-link {
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.72rem;
            padding: 0.72rem 0.85rem;
            border-radius: 0.8rem;
            font-weight: 500;
            transition: all 0.18s ease;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.13);
            color: #fff;
            transform: translateX(2px);
        }

        .btn-logout {
            border-radius: 0.8rem;
            border: 1px solid rgba(255, 255, 255, 0.32);
            color: #fff;
            background: transparent;
            padding: 0.62rem 0.8rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
        }

        .admin-main {
            min-width: 0;
            padding: 1.2rem 1.4rem;
        }

        .admin-topbar {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--line);
            border-radius: 1rem;
            padding: 0.95rem 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            box-shadow: 0 10px 28px rgba(17, 43, 84, 0.08);
            margin-bottom: 1rem;
        }

        .page-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #102a54;
        }

        .page-subtitle {
            font-size: 0.86rem;
            color: var(--muted);
        }

        .profile-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: #fff;
            padding: 0.38rem 0.55rem;
        }

        .avatar-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, #d9e8fb, #b8d1f5);
            color: #103062;
            font-weight: 700;
        }

        .profile-name {
            font-size: 0.84rem;
            font-weight: 600;
            color: #102a54;
            line-height: 1.1;
        }

        .profile-role {
            font-size: 0.75rem;
            color: var(--muted);
            line-height: 1.1;
        }

        .card-elegant {
            border: 1px solid var(--line);
            box-shadow: 0 12px 30px rgba(18, 50, 98, 0.08);
            border-radius: 1.05rem;
            background: var(--card);
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
            background-color: #0f172a;
            border-color: #0f172a;
            color: #fff;
        }

        .btn-primary:hover,
        .btn-navy:hover {
            background-color: #1e2b4b;
            border-color: #1e2b4b;
            color: #fff;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.18);
        }

        .btn-secondary,
        .btn-light {
            background: #f5f8ff;
            border: 1px solid #b9c9e8;
            color: #0f172a;
        }

        .btn-secondary:hover,
        .btn-light:hover {
            background: #eaf1ff;
            border-color: #a7bce3;
            color: #0f172a;
        }

        .btn-outline-primary,
        .btn-outline-secondary {
            border-color: #0f172a;
            color: #0f172a;
            background: transparent;
            border-radius: 10px;
        }

        .btn-outline-primary:hover,
        .btn-outline-secondary:hover {
            background: #0f172a;
            border-color: #0f172a;
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

        .table {
            --bs-table-bg: transparent;
        }

        .table thead th {
            background-color: #f4f8ff;
            color: #1f3f71;
            font-weight: 600;
            border-bottom: 1px solid #deebfb;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .form-control,
        .form-select,
        .form-check-input {
            border-radius: 0.72rem;
            border-color: #d6e1f1;
        }

        .form-control:focus,
        .form-select:focus,
        .form-check-input:focus {
            border-color: #96b7e3;
            box-shadow: 0 0 0 0.2rem rgba(29, 117, 210, 0.14);
        }

        @media (max-width: 991px) {
            .admin-shell {
                grid-template-columns: 1fr;
            }

            .admin-sidebar {
                position: relative;
                height: auto;
                border-right: 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            }

            .admin-main {
                padding: 0.9rem;
            }

            .admin-topbar {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
<div class="admin-shell">
    @include('admin.components.sidebar')

    <main class="admin-main">
        @include('admin.components.navbar', ['title' => $title ?? 'Admin'])

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
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
