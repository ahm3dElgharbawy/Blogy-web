<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blogy — Modern Blog')</title>
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            padding-top: var(--nav-h);
        }

        /* HERO */
        .hero {
            background: var(--ink);
            padding: 90px 0 70px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 50%;
            background: repeating-linear-gradient(-45deg, transparent, transparent 40px, rgba(201, 74, 44, .04) 40px, rgba(201, 74, 44, .04) 80px);
        }

        .hero-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-tag {
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .hero h1 {
            font-size: clamp(40px, 5vw, 68px);
            font-weight: 900;
            line-height: 1.1;
            color: var(--paper);
            margin-bottom: 24px;
        }

        .hero h1 em {
            color: var(--gold);
            font-style: italic;
        }

        .hero p {
            color: var(--muted);
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 36px;
            max-width: 400px;
        }

        .hero-btns {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .hero-card {
            background: var(--card);
            border-radius: 4px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            cursor: pointer;
            transition: transform .3s;
        }

        .hero-card:hover {
            transform: translateY(-4px);
        }

        .hero-card-img {
            height: 200px;
            background: linear-gradient(135deg, #1a2a3a 0%, #3a4a5c 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-card-img .big-letter {
            font-size: 120px;
            font-weight: 900;
            color: rgba(255, 255, 255, .1);
        }

        .hero-card-img .badge {
            position: absolute;
            top: 16px;
            left: 16px;
            background: var(--primary);
            color: #fff;
            font-family: 'DM Mono', monospace;
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 2px;
        }

        .hero-card-body {
            padding: 24px;
        }

        .hero-card-body h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .hero-card-body p {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 16px;
        }

        /* LAYOUT */
        .main-layout {
            max-width: 1100px;
            margin: 0 auto;
            padding: 60px 40px;
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 48px;
        }

        .posts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        /* SIDEBAR */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .sidebar-widget {
            background: var(--card);
            border-radius: 4px;
            padding: 24px;
            box-shadow: var(--shadow);
        }

        .widget-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--border);
        }

        .search-box {
            display: flex;
            border: 1px solid var(--border);
            border-radius: 2px;
            overflow: hidden;
        }

        .search-box input {
            flex: 1;
            padding: 10px 14px;
            border: none;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            background: var(--cream);
        }

        .search-box button {
            background: var(--primary);
            border: none;
            padding: 10px 14px;
            cursor: pointer;
            color: #fff;
        }

        .cat-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .cat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 14px;
            background: var(--cream);
            border-radius: 2px;
            cursor: pointer;
            transition: .2s;
            font-size: 13px;
            font-weight: 500;
            border-left: 3px solid transparent;
            text-decoration: none;
            color: inherit;
        }

        .cat-item:hover {
            border-left-color: var(--primary);
            background: #f0ece4;
        }

        .cat-count {
            background: var(--border);
            color: var(--muted);
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .newsletter-widget {
            background: var(--ink);
        }

        .newsletter-widget .widget-title {
            color: var(--paper);
            border-color: rgba(245, 240, 232, .15);
        }

        .newsletter-widget p {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 14px;
            line-height: 1.6;
        }

        .newsletter-input {
            width: 100%;
            padding: 10px 14px;
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 2px;
            margin-bottom: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 13px;
            color: var(--paper);
            outline: none;
        }

        .newsletter-input::placeholder {
            color: var(--muted);
        }

        .newsletter-btn {
            width: 100%;
            background: var(--primary);
            border: none;
            color: #fff;
            padding: 10px;
            font-family: 'DM Mono', monospace;
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 2px;
            transition: .2s;
        }

        .newsletter-btn:hover {
            background: #a83820;
        }

        .tag-cloud {
            display: grid;
            grid-template-columns: auto auto auto;
            gap: 5px;
        }

        @media(max-width:900px) {
            .hero-inner {
                grid-template-columns: 1fr
            }

            .hero-card {
                display: none
            }

            .main-layout {
                grid-template-columns: 1fr
            }

            .sidebar {
                display: none
            }

            .posts-grid {
                grid-template-columns: 1fr
            }
        }
    </style>
</head>

<body>

    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')

    <div class="toast" id="toast"></div>
    <script src="{{ asset('js/data.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
