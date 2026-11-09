<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', "Admin - S'Spotlight")</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('styles')
</head>

<body>

<div class="admin-layout">

    @include('admin.partials.sidebar')

    <div class="admin-content-wrapper">

        <!-- TOPBAR (mobile hamburger) -->
        <div class="mobile-topbar">

            <button type="button" class="hamburger-btn" id="sidebarToggle" aria-label="Buka menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="mobile-topbar-logo">S'<span>Spotlight</span></div>

        </div>

        <main class="admin-main">
            @yield('content')
        </main>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

<script src="{{ asset('js/admin.js') }}"></script>

@yield('scripts')
@stack('scripts')

</body>
</html>
