<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>@yield('title', 'Dashboard — INKWELL')</title>
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>

<body>

    <nav>
        <a href="/" class="nav-logo">B<span>LOGY</span></a>
        <div class="nav-links">
            <a href="/" class="nav-btn">← Blog</a>
        </div>
    </nav>

    <div class="dash-layout">
        <!-- SIDEBAR -->
        @include('partials.dashboard-sidebar')
        <!-- MAIN -->
        <main class="dash-main">
            @yield('content')
        </main>
    </div>

    <div class="toast" id="toast"></div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/data.js') }}"></script>
    <script src="{{ asset('js/auth.js') }}"></script>
    <script>
        const successMessage = @json(session('success'));
        if (successMessage) {
            showToast(successMessage, "success");
        }
    </script>
    @stack('scripts')
    {{-- <script src="{{ asset('js/dashboard.js') }}"></script> --}}
</body>

</html>
