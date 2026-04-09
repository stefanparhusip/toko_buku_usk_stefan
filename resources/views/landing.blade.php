<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Market App</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --navy: #0b1d3a;
            --navy-soft: #16355f;
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
            min-height: 52px;
        }

        .search-pill .form-control,
        .search-pill .input-group-text {
            border: 0;
            box-shadow: none;
            background: #fff;
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
            background: #0f172a;
            border-color: #0f172a;
            color: #fff;
        }

        .btn-primary:hover,
        .btn-navy:hover {
            background: #1e2b4b;
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
        }

        .btn-outline-primary:hover,
        .btn-outline-secondary:hover {
            background: #0f172a;
            border-color: #0f172a;
            color: #fff;
        }

        .hero-card {
            border: 0;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(22, 53, 95, 0.13);
        }

        .hero-caption {
            position: absolute;
            left: 2rem;
            right: 2rem;
            bottom: 2rem;
            text-align: left;
            z-index: 2;
            color: #fff;
            max-width: 70%;
        }

        .hero-title {
            font-size: clamp(1.4rem, 3vw, 2.6rem);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 0.45rem;
        }

        .hero-subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.88);
            margin-bottom: 0.75rem;
        }

        .hero-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffe286;
            margin-bottom: 0.95rem;
        }

        .hero-main {
            min-height: 420px;
            background:
                radial-gradient(circle at 85% 20%, rgba(255, 190, 190, 0.24) 0%, transparent 45%),
                linear-gradient(130deg, #7a1414 0%, #9e1a1a 38%, #5e0f0f 100%);
            color: #fff6df;
        }

        .promo-mini {
            min-height: 204px;
            color: #fff;
            border-radius: 1rem;
            padding: 1.2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .promo-one {
            background: linear-gradient(135deg, #121212, #1f2837);
        }

        .promo-two {
            background: linear-gradient(135deg, #835229, #b57c3f);
        }

        .slot-card {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            background: #fff;
            border: 1px solid #d7e2f3;
            box-shadow: 0 10px 26px rgba(19, 46, 88, 0.09);
        }

        .slot-hoverable {
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .slot-hoverable .slot-image {
            transition: transform 0.3s ease;
            transform-origin: center center;
        }

        .slot-hoverable .slot-overlay {
            transition: background 0.3s ease, color 0.3s ease;
            background: linear-gradient(180deg, rgba(10, 31, 68, 0.12) 0%, rgba(10, 31, 68, 0.84) 100%);
        }

        .slot-hoverable .slot-overlay h2,
        .slot-hoverable .slot-overlay h4,
        .slot-hoverable .slot-overlay p {
            transition: color 0.3s ease, opacity 0.3s ease;
        }

        .slot-hoverable .slot-overlay .btn {
            opacity: 0.88;
            transform: translateY(2px);
            transition: opacity 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        .slot-hoverable:hover {
            transform: scale(1.04);
            box-shadow: 0 20px 42px rgba(10, 31, 68, 0.34);
        }

        .slot-card-hero.slot-hoverable:hover {
            transform: scale(1.03);
        }

        .slot-card-banner.slot-hoverable:hover {
            transform: scale(1.05);
        }

        .slot-hoverable:hover .slot-image {
            transform: scale(1.05);
        }

        .slot-hoverable:hover .slot-overlay {
            background: linear-gradient(180deg, rgba(10, 31, 68, 0.2) 0%, rgba(10, 31, 68, 0.95) 100%);
        }

        .slot-hoverable:hover .slot-overlay h2,
        .slot-hoverable:hover .slot-overlay h4,
        .slot-hoverable:hover .hero-subtitle,
        .slot-hoverable:hover .slot-overlay p {
            color: #ffffff !important;
            opacity: 1;
        }

        .slot-hoverable:hover .slot-overlay .btn {
            opacity: 1;
            transform: translateY(0);
            box-shadow: 0 10px 24px rgba(6, 19, 40, 0.35);
        }

        .slot-admin-highlight {
            border: 2px dashed #9db7df;
        }

        .slot-card-hero {
            min-height: 420px;
        }

        .hero-slider {
            position: relative;
            height: 100%;
        }

        .hero-slider-track {
            display: flex;
            width: 100%;
            height: 100%;
            transition: transform 0.45s ease;
        }

        .hero-slide {
            min-width: 100%;
            height: 100%;
            position: relative;
        }

        .hero-slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            width: 42px;
            height: 42px;
            border: 0;
            border-radius: 999px;
            background: rgba(11, 29, 58, 0.78);
            color: #fff;
            font-size: 1.45rem;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .hero-slider-btn.prev {
            left: 14px;
        }

        .hero-slider-btn.next {
            right: 14px;
        }

        .hero-slider-indicators {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 12px;
            z-index: 6;
            display: flex;
            justify-content: center;
            gap: 0.42rem;
        }

        .hero-slider-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            border: 0;
            background: rgba(255, 255, 255, 0.55);
            padding: 0;
        }

        .hero-slider-dot.active {
            background: #fff;
            transform: scale(1.16);
        }

        .slot-card-banner {
            min-height: 202px;
        }

        .slot-card-book {
            min-height: 100%;
        }

        .slot-label {
            position: absolute;
            top: 0.6rem;
            left: 0.6rem;
            z-index: 3;
            background: rgba(10, 31, 68, 0.88);
            color: #fff;
            border-radius: 0.6rem;
            font-size: 0.76rem;
            font-weight: 600;
            padding: 0.24rem 0.52rem;
        }

        .slot-edit {
            position: absolute;
            top: 0.6rem;
            right: 0.6rem;
            z-index: 3;
        }

        .slot-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .slot-overlay {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
            color: #fff;
            padding: 1.4rem 1.2rem 1.1rem;
            background: linear-gradient(180deg, rgba(10, 31, 68, 0.08) 0%, rgba(10, 31, 68, 0.9) 100%);
        }

        .slot-empty {
            min-height: inherit;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: repeating-linear-gradient(45deg, #eef3ff, #eef3ff 14px, #e6eeff 14px, #e6eeff 28px);
            color: #5f7191;
            text-align: center;
            padding: 1.2rem;
        }

        .book-slider {
            position: relative;
            margin-top: 0.75rem;
        }

        .book-slider-track {
            display: flex;
            gap: 0.95rem;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            padding: 0.35rem 0.15rem 0.9rem;
            overscroll-behavior-x: contain;
            touch-action: pan-y;
        }

        .book-slider-track::-webkit-scrollbar {
            display: none;
        }

        .book-slider-item {
            flex: 0 0 clamp(220px, 23vw, 272px);
            max-width: 272px;
        }

        .book-slider-item .product-card,
        .book-slider-item .slot-card {
            transition: transform 0.22s ease, box-shadow 0.22s ease;
        }

        .book-slider-item .product-card:hover,
        .book-slider-item .slot-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 30px rgba(18, 50, 98, 0.16);
        }

        .book-slider-btn {
            position: absolute;
            top: 42%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border-radius: 0.7rem;
            border: 1px solid #d0def4;
            background: rgba(255, 255, 255, 0.95);
            color: #0A1F44;
            box-shadow: 0 8px 22px rgba(16, 44, 88, 0.18);
            z-index: 4;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            line-height: 1;
            font-size: 0;
        }

        .book-slider-btn[hidden] {
            display: none !important;
        }

        .book-slider-btn svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .book-slider-btn:hover {
            background: #0A1F44;
            border-color: #0A1F44;
            color: #fff;
        }

        .book-slider-prev {
            left: 0;
        }

        .book-slider-next {
            right: 0;
        }

        @media (max-width: 991px) {
            .book-slider-item {
                flex-basis: min(76vw, 260px);
            }

            .book-slider-btn {
                width: 30px;
                height: 30px;
            }
        }

        .quick-icon {
            width: 68px;
            height: 68px;
            border-radius: 1rem;
            display: grid;
            place-items: center;
            font-size: 1.4rem;
            background: linear-gradient(145deg, #fff, #f2f5fb);
            box-shadow: 0 6px 18px rgba(16, 42, 80, 0.1);
        }

        .tag-row {
            white-space: nowrap;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .tag-row::-webkit-scrollbar {
            display: none;
        }

        .tag-chip {
            background: #eef4ff;
            border: 1px solid #dbe8ff;
            color: #2a4f84;
            border-radius: 999px;
            font-size: 0.86rem;
            padding: 0.3rem 0.75rem;
            display: inline-flex;
            align-items: center;
            margin-right: 0.45rem;
            text-decoration: none;
            transition: box-shadow 0.2s ease, transform 0.2s ease, background-color 0.2s ease;
        }

        .tag-chip:hover {
            background: #e6f0ff;
            box-shadow: 0 8px 18px rgba(25, 69, 133, 0.14);
            transform: translateY(-1px);
            color: #1f4576;
        }

        .btn-category {
            border-radius: 999px;
            min-width: 136px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            min-height: 52px;
            font-weight: 600;
        }

        .btn-category.active {
            background: #eef3fb;
            border-color: #c8d7ee;
        }

        .mega-backdrop {
            display: none;
        }

        .mega-backdrop.show {
            display: none;
        }

        .mega-overlay {
            position: absolute;
            left: 0;
            right: 0;
            top: 100%;
            z-index: 1200;
            opacity: 0;
            transform: translateY(-10px);
            pointer-events: none;
            transition: opacity 0.22s ease, transform 0.22s ease;
        }

        .mega-overlay.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .mega-wrapper {
            border-top: 1px solid #dbe3ef;
            background: #f8f9fb;
            box-shadow: inset 0 -1px 0 #e6ebf4;
        }

        .mega-panel {
            background: #f4f4f6;
            border-radius: 0 0 1.6rem 1.6rem;
            border: 1px solid #d9dde6;
            border-top: 0;
            padding: 1.5rem 2rem 1.1rem;
        }

        .mega-left {
            border-right: 1px solid #d8dde7;
            padding-right: 2rem;
        }

        .switch-pill {
            background: #e3e4e6;
            border-radius: 999px;
            display: inline-flex;
            padding: 0.25rem;
            gap: 0.3rem;
            margin-bottom: 1rem;
        }

        .switch-pill .nav-link {
            border-radius: 999px;
            color: #2a2e36;
            min-width: 140px;
            font-weight: 500;
            border: 0;
            padding: 0.55rem 1rem;
        }

        .switch-pill .nav-link.active {
            background: #343a40;
            color: #fff;
        }

        .menu-list a {
            display: block;
            text-decoration: none;
            color: #2b2f39;
            font-size: 1.05rem;
            margin: 0.55rem 0;
            line-height: 1.35;
        }

        .menu-list .group-title {
            font-size: 1.12rem;
            font-weight: 700;
            margin: 0.45rem 0;
            color: #2f323a;
        }

        .menu-col .sub-title {
            font-size: 1.12rem;
            font-weight: 700;
            margin-bottom: 0.55rem;
            color: #2f323a;
        }

        .menu-col a {
            display: block;
            text-decoration: none;
            color: #2b2f39;
            font-size: 1.03rem;
            margin-bottom: 0.5rem;
            line-height: 1.35;
        }

        .section-title {
            font-size: 1.95rem;
            font-weight: 700;
            color: #2f3947;
        }

        .section-link {
            color: #1f2937;
            text-decoration: underline;
            font-weight: 500;
        }

        .category-tile {
            height: 170px;
            border-radius: 0.9rem;
            overflow: hidden;
            position: relative;
            background: linear-gradient(140deg, #6f7685, #364258);
            box-shadow: 0 8px 22px rgba(36, 53, 82, 0.15);
        }

        .category-tile::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(18, 22, 28, 0.78) 2%, rgba(18, 22, 28, 0.18) 50%, rgba(18, 22, 28, 0));
        }

        .category-tile h6 {
            position: absolute;
            left: 1rem;
            bottom: 0.8rem;
            z-index: 2;
            margin: 0;
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            line-height: 1.05;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.35);
        }

        .tile-1 { background: linear-gradient(130deg, #5e646f, #2f3d53), url('https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=700&q=60') center/cover; }
        .tile-2 { background: linear-gradient(130deg, #5e646f, #2f3d53), url('https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=700&q=60') center/cover; }
        .tile-3 { background: linear-gradient(130deg, #5e646f, #2f3d53), url('https://images.unsplash.com/photo-1511108690759-009324a90311?auto=format&fit=crop&w=700&q=60') center/cover; }
        .tile-4 { background: linear-gradient(130deg, #5e646f, #2f3d53), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=700&q=60') center/cover; }
        .tile-5 { background: linear-gradient(130deg, #5e646f, #2f3d53), url('https://images.unsplash.com/photo-1513001900722-370f803f498d?auto=format&fit=crop&w=700&q=60') center/cover; }

        .ad-vertical {
            border-radius: 1.1rem;
            min-height: 400px;
            background: linear-gradient(160deg, #4c75ff, #3e58b6);
            color: #fff;
            box-shadow: 0 10px 25px rgba(32, 73, 164, 0.22);
            position: relative;
            overflow: hidden;
        }

        .ad-vertical .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.13);
        }

        .ad-vertical .b1 { width: 160px; height: 160px; top: -35px; right: -35px; }
        .ad-vertical .b2 { width: 130px; height: 130px; bottom: -20px; left: -20px; }

        .product-card {
            border: 1px solid #dfe4ee;
            border-radius: 1rem;
            background: #fff;
            overflow: hidden;
            height: 100%;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(23, 44, 76, 0.14);
        }

        .product-thumb {
            height: 228px;
            background: #eceff4;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #98a1b3;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .product-title {
            font-size: 1.12rem;
            font-weight: 600;
            line-height: 1.25;
            color: #2c3340;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .price {
            font-size: 1.85rem;
            font-weight: 700;
            color: #2c3340;
        }

        .mini-head {
            font-size: 1.9rem;
            font-weight: 700;
            color: #313a49;
        }

        .official-item {
            border: 1px solid #dfe4ee;
            border-radius: 1rem;
            background: #fff;
            padding: 1.2rem 0.9rem;
            text-align: center;
            min-height: 192px;
        }

        .official-logo {
            height: 72px;
            border-radius: 0.7rem;
            background: #f4f7fc;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8693a8;
            margin-bottom: 0.8rem;
            font-weight: 700;
        }

        .blog-card {
            border: 1px solid #dfe4ee;
            border-radius: 1rem;
            background: #fff;
            overflow: hidden;
        }

        .blog-image {
            height: 250px;
            background: linear-gradient(145deg, #f39f6f, #cc5d4a);
        }

        .social-banner {
            border-radius: 1rem;
            background: linear-gradient(140deg, #2f5ce0, #1f74d4);
            color: #fff;
            overflow: hidden;
            min-height: 190px;
            display: flex;
            align-items: center;
            padding: 1.4rem;
        }

        .landing-footer {
            background: linear-gradient(145deg, #091833, #0f254a);
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .landing-footer p,
        .landing-footer .text-light-emphasis {
            color: rgba(233, 242, 255, 0.9) !important;
        }

        .landing-footer .footer-meta {
            color: rgba(226, 237, 255, 0.88);
        }

        .footer-link {
            color: rgba(241, 247, 255, 0.94);
            text-decoration: none;
            display: block;
            margin-bottom: 0.45rem;
        }

        .footer-link:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .book-card {
            cursor: pointer;
        }

        .big-label {
            font-size: 1.7rem;
        }

        .section-block {
            margin-top: 3.25rem;
        }

        .floating-help {
            position: fixed;
            right: 18px;
            bottom: 18px;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(140deg, #7db3ff, #2a63df);
            color: #fff;
            display: grid;
            place-items: center;
            font-size: 0.72rem;
            text-align: center;
            line-height: 1.05;
            border: 4px solid #fff;
            box-shadow: 0 8px 22px rgba(29, 67, 142, 0.35);
            z-index: 1015;
        }

        .quick-edit-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 5;
        }

        @media (max-width: 991px) {
            .section-title,
            .mini-head {
                font-size: 1.5rem;
            }

            .category-tile h6 {
                font-size: 1.3rem;
            }

            .big-label {
                font-size: 1.35rem;
            }

            .section-block {
                margin-top: 2.2rem;
            }

            .hero-main {
                min-height: 360px;
            }

            .hero-caption {
                left: 1.15rem;
                right: 1.15rem;
                bottom: 1.45rem;
                max-width: 92%;
            }

            .hero-title {
                font-size: 1.32rem;
            }

            .hero-subtitle {
                font-size: 0.92rem;
            }

            .hero-price {
                font-size: 1.18rem;
            }

            .promo-mini {
                min-height: 170px;
            }

            .mega-left {
                border-right: 0;
                border-bottom: 1px solid #d8dde7;
                padding-right: 0;
                padding-bottom: 1rem;
                margin-bottom: 1rem;
            }

            .switch-pill .nav-link {
                min-width: 120px;
                font-size: 0.92rem;
            }

            .menu-list a,
            .menu-col a {
                font-size: 1rem;
            }

            .mega-overlay {
                position: fixed;
                top: 86px;
                max-height: calc(100vh - 100px);
                overflow: auto;
            }

            .menu-list .group-title,
            .menu-col .sub-title {
                font-size: 1.2rem;
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
                <a href="/" class="brand-wrap text-decoration-none">
                    <span class="brand-logo-box">
                        <img src="{{ asset('img/logo 3bie.png') }}" alt="3bieStore Logo" class="brand-logo">
                    </span>
                    <span class="brand-text">
                        <span class="brand-main">3bie</span><span class="brand-sub">Store</span>
                    </span>
                </a>
            </div>

            <div class="col-lg-6 col-md-8">
                <div class="d-flex align-items-center gap-2">
                    <button id="categoryToggle" class="btn btn-light border btn-category" type="button" aria-expanded="false" aria-controls="categoryOverlay" aria-label="Toggle kategori menu">
                        <span>⌃</span>
                        <span>Kategori</span>
                    </button>
                    <form method="GET" action="{{ route('search') }}" class="input-group search-pill" role="search">
                        <button type="submit" class="input-group-text" style="cursor:pointer;">🔎</button>
                        <input type="text" name="q" class="form-control" placeholder="Cari produk, judul buku, atau penulis" value="{{ request('q', '') }}">
                    </form>
                </div>
            </div>

            <div class="col-lg-3 d-flex justify-content-lg-end gap-2">
                @auth
                    <div class="d-flex flex-wrap justify-content-lg-end gap-2">
                        <a href="{{ route('landing') }}" class="btn btn-outline-secondary btn-sm">Home</a>
                        <a href="{{ route('promo.index') }}" class="btn btn-outline-secondary btn-sm">Promo</a>
                        <a href="{{ route('about') }}" class="btn btn-outline-secondary btn-sm">About</a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-secondary btn-sm">Contact</a>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary btn-sm">Cart</a>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">Orders</a>
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">Admin Panel</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-navy btn-sm">Logout</button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-navy">Daftar</a>
                @endauth
            </div>
        </div>

        <div class="tag-row mt-2 pb-1">
            @forelse ($categories->take(7) as $category)
                <a href="{{ route('categories.books', $category->id) }}" class="tag-chip">
                    {{ $category->name }}
                </a>
            @empty
                <span class="tag-chip">Belum ada kategori</span>
            @endforelse
        </div>
    </div>

    <div id="categoryOverlay" class="mega-overlay" role="dialog" aria-modal="false" aria-label="Kategori Menu">
        <div class="mega-wrapper">
            <div class="container container-wide">
                <div class="mega-panel">
                    <div class="row g-4">
                        <div class="col-lg-4 mega-left">
                            <div class="menu-list">
                                <div class="group-title">Kategori Buku</div>
                                <a href="{{ route('books.index') }}">Semua Kategori</a>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            @php
                                $total = $categories->count();
                                $chunkSize = max(1, (int) ceil(max($total, 1) / 3));
                                $categoryChunks = $categories->chunk($chunkSize);
                            @endphp

                            @if ($categories->isEmpty())
                                <div class="p-3 text-muted">Belum ada kategori buku.</div>
                            @else
                                <div class="row g-4">
                                    @foreach ($categoryChunks as $chunk)
                                        <div class="col-lg-4 col-md-6 menu-col">
                                            @foreach ($chunk as $category)
                                                <a href="{{ route('categories.books', $category->id) }}">{{ $category->name }}</a>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-4">
    <div class="container container-wide">
        <div class="alert" style="background:#e8f5e8; border:1px solid #cae8ca; color:#2e6a2e;">
             Nikmati moment berbelanja yang menyenangkan, klik buku yang diinginkan, bayar, buku sudah ada di tanganmu!!!
        </div>

        @php
            $isAdminViewer = auth()->check() && auth()->user()->role === 'admin';
            $slotBannerTop = $homepageSlots->get(2);
            $slotBannerBottom = $homepageSlots->get(3);
            $heroItems = $slotOneItems->values();

            $shouldShowSlot = function ($slot) use ($isAdminViewer) {
                return $slot && ($isAdminViewer || $slot->is_active);
            };

            $resolveSlotLink = function ($slot, $fallback = 'books.index') {
                if (! $slot) {
                    return route('books.index');
                }

                if ($slot->link) {
                    $rawLink = trim((string) $slot->link);
                    $isInvalidPlaceholder = $rawLink === '#'
                        || \Illuminate\Support\Str::startsWith(strtolower($rawLink), 'javascript:');

                    if ($rawLink !== '' && ! $isInvalidPlaceholder) {
                        return $rawLink;
                    }
                }

                if (isset($slot->book) && $slot->book) {
                    return route('books.show', $slot->book->id);
                }

                return route($fallback);
            };

            $showHeroColumn = $heroItems->isNotEmpty() || $isAdminViewer;
            $showBannerColumn = $shouldShowSlot($slotBannerTop) || $shouldShowSlot($slotBannerBottom) || $isAdminViewer;
        @endphp

        <div class="row g-3">
            <div class="{{ $showBannerColumn ? 'col-lg-8' : 'col-lg-12' }}">
                @if ($showHeroColumn && $heroItems->count() > 1)
                    <div class="slot-card slot-card-hero {{ $isAdminViewer ? 'slot-admin-highlight' : '' }}" data-hero-slider>
                        @if ($isAdminViewer)
                            <span class="slot-label">Slot 1</span>
                            @if ($slotOne)
                                <a href="{{ route('admin.homepage-slots.edit', $slotOne) }}" class="btn btn-sm btn-light slot-edit">Edit</a>
                            @endif
                        @endif

                        <div class="hero-slider">
                            <div class="hero-slider-track" data-hero-track>
                                @foreach ($heroItems as $heroItem)
                                    <div class="hero-slide">
                                        <div class="slot-card slot-card-hero slot-hoverable" data-slot-href="{{ $resolveSlotLink($heroItem, 'promo.index') }}">
                                            @if ($heroItem->image_source)
                                                <img src="{{ $heroItem->image_source }}" alt="{{ $heroItem->title }}" class="slot-image">
                                            @else
                                                <div class="slot-empty"><strong>Image belum diupload</strong></div>
                                            @endif

                                            <div class="slot-overlay">
                                                <h2 class="hero-title mb-2">{{ $heroItem->title ?: 'Slider Hero Homepage' }}</h2>
                                                @if ($heroItem->description)
                                                    <p class="hero-subtitle mb-3">{{ \Illuminate\Support\Str::limit($heroItem->description, 160) }}</p>
                                                @endif
                                                <a href="{{ $resolveSlotLink($heroItem, 'promo.index') }}" class="btn btn-light fw-semibold">{{ $heroItem->button_text ?: 'Lihat Detail' }}</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="hero-slider-btn prev" data-hero-prev aria-label="Slide sebelumnya">&#8249;</button>
                            <button type="button" class="hero-slider-btn next" data-hero-next aria-label="Slide berikutnya">&#8250;</button>

                            <div class="hero-slider-indicators" data-hero-indicators>
                                @foreach ($heroItems as $heroIndex => $heroItem)
                                    <button type="button" class="hero-slider-dot {{ $heroIndex === 0 ? 'active' : '' }}" data-hero-dot="{{ $heroIndex }}" aria-label="Slide {{ $heroIndex + 1 }}"></button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @elseif ($showHeroColumn && $heroItems->count() === 1)
                    @php
                        $heroItem = $heroItems->first();
                    @endphp
                    <div class="slot-card slot-card-hero slot-hoverable {{ $isAdminViewer ? 'slot-admin-highlight' : '' }}" data-slot-href="{{ $resolveSlotLink($heroItem, 'promo.index') }}">
                        @if ($isAdminViewer)
                            <span class="slot-label">Slot 1</span>
                            @if ($slotOne)
                                <a href="{{ route('admin.homepage-slots.edit', $slotOne) }}" class="btn btn-sm btn-light slot-edit">Edit</a>
                            @endif
                        @endif

                        @if ($heroItem->image_source)
                            <img src="{{ $heroItem->image_source }}" alt="{{ $heroItem->title }}" class="slot-image">
                        @else
                            <div class="slot-empty"><strong>Image belum diupload</strong></div>
                        @endif

                        <div class="slot-overlay">
                            <h2 class="hero-title mb-2">{{ $heroItem->title ?: 'Slider Hero Homepage' }}</h2>
                            @if ($heroItem->description)
                                <p class="hero-subtitle mb-3">{{ \Illuminate\Support\Str::limit($heroItem->description, 160) }}</p>
                            @endif
                            <a href="{{ $resolveSlotLink($heroItem, 'promo.index') }}" class="btn btn-light fw-semibold">{{ $heroItem->button_text ?: 'Lihat Detail' }}</a>
                        </div>
                    </div>
                @elseif ($isAdminViewer)
                    <div class="slot-card slot-card-hero slot-admin-highlight">
                        <span class="slot-label">Slot 1</span>
                        <div class="slot-empty">
                            <div>
                                <h4 class="mb-2">Slot 1 kosong</h4>
                                @if ($slotOne)
                                    <a href="{{ route('admin.homepage-slots.edit', $slotOne) }}" class="btn btn-sm btn-outline-primary">Isi Slot dari Admin</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if ($showBannerColumn)
                <div class="col-lg-4 d-flex flex-column gap-3">
                    @foreach ([2 => $slotBannerTop, 3 => $slotBannerBottom] as $position => $slot)
                        @if ($shouldShowSlot($slot))
                            <div
                                class="slot-card slot-card-banner slot-hoverable {{ $isAdminViewer ? 'slot-admin-highlight' : '' }}"
                                data-slot-href="{{ $resolveSlotLink($slot) }}"
                            >
                                @if ($isAdminViewer)
                                    <span class="slot-label">Slot {{ $position }}</span>
                                    <a href="{{ route('admin.homepage-slots.edit', $slot) }}" class="btn btn-sm btn-light slot-edit">Edit</a>
                                @endif

                                @if ($slot->image_source)
                                    <img src="{{ $slot->image_source }}" alt="{{ $slot->title }}" class="slot-image">
                                @endif

                                <div class="slot-overlay">
                                    <h4 class="mb-1">{{ $slot->title ?: 'Banner Slot '.$position }}</h4>
                                    @if ($slot->description)
                                        <p class="mb-2 small text-white-50">{{ \Illuminate\Support\Str::limit($slot->description, 72) }}</p>
                                    @endif
                                    <a href="{{ $resolveSlotLink($slot) }}" class="btn btn-sm btn-light">Buka</a>
                                </div>
                            </div>
                        @elseif ($isAdminViewer)
                            <div class="slot-card slot-card-banner slot-admin-highlight">
                                <span class="slot-label">Slot {{ $position }}</span>
                                <div class="slot-empty">
                                    <div>
                                        <strong>Slot {{ $position }} kosong</strong>
                                        <div class="small mt-1">Tambahkan banner dari panel admin.</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>

        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-8 g-4 mt-2 text-center">
            @php
                $quickIconMap = [
                    'novel' => '📗',
                    'komik' => '📕',
                    'e-book' => '📘',
                    'buku anak' => '🧸',
                    'cerita anak' => '🧸',
                    'pendidikan' => '🎓',
                    'bisnis & ekonomi' => '💼',
                    'fantasi' => '🧙',
                    'psikologi' => '🧠',
                ];
            @endphp

            @forelse ($categories->take(8) as $category)
                @php
                    $categoryKey = strtolower($category->name);
                    $categoryIcon = $quickIconMap[$categoryKey] ?? '📚';
                @endphp
                <div class="col">
                    <a href="{{ route('categories.books', $category->id) }}" class="text-decoration-none text-dark">
                        <div class="quick-icon mx-auto">{{ $categoryIcon }}</div>
                        <p class="small mt-2 mb-0">{{ $category->name }}</p>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-muted">Belum ada kategori buku.</div>
                </div>
            @endforelse
        </div>

        @if ($activePromos->isNotEmpty())
            <div class="section-block pt-1 d-flex align-items-center justify-content-between">
                <h2 class="section-title mb-0">Promo Pilihan</h2>
                <a href="{{ route('promo.index') }}" class="section-link">Lihat Semua</a>
            </div>

            <div class="row g-3 mt-2">
                @foreach ($activePromos as $promo)
                    <div class="col-md-6 col-lg-4">
                        <div class="product-card h-100 position-relative">
                            @auth
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-sm btn-outline-primary quick-edit-btn">Edit</a>
                                @endif
                            @endauth
                            <a href="{{ route('promo.index') }}" class="d-block">
                                <img
                                    src="{{ $promo->image ? asset('storage/' . $promo->image) : 'https://placehold.co/900x520?text=Promo' }}"
                                    alt="{{ $promo->title }}"
                                    class="w-100"
                                    style="height: 220px; object-fit: cover;"
                                >
                            </a>
                            <div class="p-3">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    @if ($promo->discount)
                                        <span class="badge text-bg-primary">Diskon {{ $promo->discount }}%</span>
                                    @endif
                                    @if ($promo->discount && $promo->discount >= 30)
                                        <span class="badge text-bg-warning">Promo Populer</span>
                                    @endif
                                </div>
                                <div class="product-title">{{ $promo->title }}</div>
                                <p class="text-muted mb-2">{{ \Illuminate\Support\Str::limit($promo->description, 90) }}</p>
                                <a href="{{ route('promo.index') }}" class="btn btn-sm btn-navy">Gunakan Promo</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="section-block pt-1 d-flex align-items-center justify-content-between">
            <h2 class="section-title mb-0">Pilihan Slot Buku</h2>
            <a href="{{ route('books.index') }}" class="section-link">Lihat Semua</a>
        </div>

        <div class="book-slider" data-book-slider>
            <button class="book-slider-btn book-slider-prev" type="button" aria-label="Geser ke kiri" data-slider-prev hidden>
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 18l-6-6 6-6"></path></svg>
            </button>

            <div class="book-slider-track" data-slider-track>
                @foreach (range(4, 10) as $position)
                    @php
                        $slot = $homepageSlots->get($position);
                        $canRenderSlot = $slot && ($isAdminViewer || $slot->is_active);
                    @endphp

                    @if ($canRenderSlot)
                        @php
                            $book = $slot->book;
                            $bookLink = $book ? route('books.show', $book->id) : ($slot->link ?: route('books.index'));
                            $bookImage = $slot->image_source ?: ($book?->image_source ?: null);
                        @endphp
                        <div class="book-slider-item">
                            <div class="product-card h-100 position-relative book-card {{ $isAdminViewer ? 'slot-admin-highlight' : '' }}" data-href="{{ $bookLink }}">
                                @if ($isAdminViewer)
                                    <span class="slot-label">Slot {{ $position }}</span>
                                    <a href="{{ route('admin.homepage-slots.edit', $slot) }}" class="btn btn-sm btn-light slot-edit">Edit</a>
                                @endif

                                <a href="{{ $bookLink }}" class="d-block">
                                    <img
                                        src="{{ $bookImage ?: 'https://placehold.co/500x700?text=Slot+'. $position }}"
                                        alt="{{ $slot->title ?: ($book?->title ?? 'Slot Buku') }}"
                                        class="w-100"
                                        style="height: 228px; object-fit: cover;"
                                    >
                                </a>
                                <div class="p-3 d-flex flex-column h-100">
                                    <small class="text-muted">{{ $book?->category?->name ?? 'Homepage Slot' }}</small>
                                    <a href="{{ $bookLink }}" class="text-decoration-none text-dark">
                                        <div class="product-title">{{ $slot->title ?: ($book?->title ?? 'Slot '.$position) }}</div>
                                    </a>
                                    @if ($slot->description)
                                        <small class="text-muted mt-1">{{ \Illuminate\Support\Str::limit($slot->description, 55) }}</small>
                                    @endif
                                    @if ($book)
                                        <div class="price mt-2">{{ $book->formatted_price }}</div>
                                    @endif

                                    <div class="mt-auto d-grid gap-2 pt-2">
                                        <a href="{{ $bookLink }}" class="btn btn-sm btn-outline-primary">{{ $book ? 'Lihat Detail' : 'Buka' }}</a>
                                        @if ($book)
                                            <form action="{{ route('cart.add', $book->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-navy w-100">Add to Cart</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($isAdminViewer)
                        <div class="book-slider-item">
                            <div class="slot-card slot-card-book slot-admin-highlight">
                                <span class="slot-label">Slot {{ $position }}</span>
                                <div class="slot-empty" style="min-height: 360px;">
                                    <div>
                                        <strong>Slot {{ $position }} kosong</strong>
                                        <div class="small mt-2">Klik menu Homepage Slots untuk mengisi konten.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <button class="book-slider-btn book-slider-next" type="button" aria-label="Geser ke kanan" data-slider-next hidden>
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 6l6 6-6 6"></path></svg>
            </button>
        </div>

        <footer class="landing-footer section-block rounded-4 overflow-hidden">
            <div class="container py-4 py-lg-5">
                <div class="row g-4">
                    <div class="col-lg-4">
                        <h5 class="fw-semibold text-white mb-3">About Us</h5>
                        <p class="text-light-emphasis mb-0">
                            3bieStore adalah toko buku online yang menyediakan koleksi buku terbaru,
                            best seller, dan rekomendasi pilihan dengan pengalaman belanja modern.
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <h5 class="fw-semibold text-white mb-3">Menu</h5>
                        <a class="footer-link" href="{{ url('/') }}">Home</a>
                        <a class="footer-link" href="{{ route('books.index') }}">Books</a>
                        <a class="footer-link" href="{{ route('books.index') }}">Categories</a>
                        <a class="footer-link" href="{{ route('contact') }}">Contact</a>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <h5 class="fw-semibold text-white mb-3">Contact Info</h5>
                        <p class="text-light-emphasis mb-1">Email: stefannamora@gmail.com</p>
                        <p class="text-light-emphasis mb-3">Phone: 0821-1466-2588</p>
                        <div class="d-flex gap-2">
                            <a href="https://instagram.com" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener">IG</a>
                            <a href="https://facebook.com" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener">FB</a>
                            <a href="https://x.com" class="btn btn-outline-light btn-sm" target="_blank" rel="noopener">X</a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-12">
                        <h5 class="fw-semibold text-white mb-3">Explore</h5>
                        <a class="footer-link" href="{{ route('about') }}">About</a>
                        @guest
                            <a class="footer-link" href="{{ route('login') }}">Masuk</a>
                            <a class="footer-link" href="{{ route('register') }}">Daftar</a>
                        @endguest
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top border-secondary-subtle footer-meta">
                    © 2026 3bieStore
                </div>
            </div>
        </footer>
    </div>
</section>

@include('user.components.contact-widget')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function () {
        window.addEventListener('wheel', function (event) {
            if (Math.abs(event.deltaX) <= Math.abs(event.deltaY)) {
                return;
            }

            const allowHorizontal = event.target.closest('[data-slider-track]');
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

            const allowHorizontal = event.target.closest('[data-slider-track]');
            if (allowHorizontal) {
                return;
            }

            event.preventDefault();
        }, { passive: false });

        const toggleBtn = document.getElementById('categoryToggle');
        const overlay = document.getElementById('categoryOverlay');

        if (!toggleBtn || !overlay) {
            return;
        }

        const openMenu = () => {
            overlay.classList.add('show');
            toggleBtn.classList.add('active');
            toggleBtn.setAttribute('aria-expanded', 'true');
        };

        const closeMenu = () => {
            overlay.classList.remove('show');
            toggleBtn.classList.remove('active');
            toggleBtn.setAttribute('aria-expanded', 'false');
        };

        toggleBtn.addEventListener('click', function (event) {
            event.preventDefault();
            if (overlay.classList.contains('show')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        document.addEventListener('click', function (event) {
            const clickedInsideMenu = overlay.contains(event.target);
            const clickedToggle = toggleBtn.contains(event.target);

            if (!clickedInsideMenu && !clickedToggle && overlay.classList.contains('show')) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && overlay.classList.contains('show')) {
                closeMenu();
            }
        });

        document.querySelectorAll('.book-card[data-href]').forEach(function (card) {
            card.addEventListener('click', function (event) {
                if (event.target.closest('a, button, form, input, textarea, select, label')) {
                    return;
                }

                window.location.href = card.getAttribute('data-href');
            });
        });

        document.querySelectorAll('.slot-hoverable[data-slot-href]').forEach(function (slotCard) {
            slotCard.addEventListener('click', function (event) {
                if (event.target.closest('a, button, form, input, textarea, select, label')) {
                    return;
                }

                const href = slotCard.getAttribute('data-slot-href');
                if (href) {
                    window.location.href = href;
                }
            });
        });

        document.querySelectorAll('[data-hero-slider]').forEach(function (slider) {
            const track = slider.querySelector('[data-hero-track]');
            const prev = slider.querySelector('[data-hero-prev]');
            const next = slider.querySelector('[data-hero-next]');
            const dots = Array.from(slider.querySelectorAll('[data-hero-dot]'));

            if (!track || dots.length === 0) {
                return;
            }

            let index = 0;
            let autoPlay = null;

            const goTo = function (nextIndex) {
                index = (nextIndex + dots.length) % dots.length;
                track.style.transform = 'translateX(' + (index * -100) + '%)';
                dots.forEach(function (dot, dotIndex) {
                    dot.classList.toggle('active', dotIndex === index);
                });
            };

            const startAutoPlay = function () {
                if (dots.length <= 1) {
                    return;
                }

                autoPlay = window.setInterval(function () {
                    goTo(index + 1);
                }, 5000);
            };

            const stopAutoPlay = function () {
                if (autoPlay) {
                    window.clearInterval(autoPlay);
                    autoPlay = null;
                }
            };

            if (prev) {
                prev.addEventListener('click', function () {
                    goTo(index - 1);
                });
            }

            if (next) {
                next.addEventListener('click', function () {
                    goTo(index + 1);
                });
            }

            dots.forEach(function (dot) {
                dot.addEventListener('click', function () {
                    goTo(Number(dot.getAttribute('data-hero-dot') || 0));
                });
            });

            slider.addEventListener('mouseenter', stopAutoPlay);
            slider.addEventListener('mouseleave', startAutoPlay);
            goTo(0);
            startAutoPlay();
        });

        const initBookSlider = function (container) {
            const scroller = container.querySelector('[data-slider-track]');
            const prevBtn = container.querySelector('[data-slider-prev]');
            const nextBtn = container.querySelector('[data-slider-next]');

            if (!scroller) {
                return;
            }

            const updateButtons = function () {
                if (!prevBtn || !nextBtn) {
                    return;
                }

                const maxScrollLeft = Math.max(0, scroller.scrollWidth - scroller.clientWidth);
                const hasOverflow = maxScrollLeft > 4;
                const atLeftEdge = scroller.scrollLeft <= 2;
                const atRightEdge = scroller.scrollLeft >= maxScrollLeft - 2;

                prevBtn.hidden = !hasOverflow || atLeftEdge;
                nextBtn.hidden = !hasOverflow || atRightEdge;
            };

            const scrollStep = function (direction) {
                scroller.scrollBy({
                    left: direction * Math.max(240, Math.round(scroller.clientWidth * 0.8)),
                    behavior: 'smooth',
                });
            };

            if (prevBtn && nextBtn) {
                prevBtn.addEventListener('click', function () {
                    scrollStep(-1);
                });

                nextBtn.addEventListener('click', function () {
                    scrollStep(1);
                });
            }

            // Consume horizontal trackpad swipe so browser back/forward gesture overlay is not triggered.
            scroller.addEventListener('wheel', function (event) {
                if (Math.abs(event.deltaX) <= 0) {
                    return;
                }

                event.preventDefault();
                scroller.scrollLeft += event.deltaX;
                updateButtons();
            }, { passive: false });

            scroller.addEventListener('scroll', updateButtons, { passive: true });
            window.addEventListener('resize', updateButtons);
            updateButtons();
        };

        document.querySelectorAll('[data-book-slider]').forEach(initBookSlider);
    })();
</script>
</body>
</html>
