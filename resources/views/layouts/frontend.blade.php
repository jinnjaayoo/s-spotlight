<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>S'Spotlight</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Sora:wght@100..800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Sora', 'sans-serif'],
                    },
                    colors: {
                        'off-white': '#FBFBFA',
                        'warm-beige': '#E7E2D6',
                        'warm-beige-light': '#F4F0E8',
                        'butter-gold': {
                            50: '#FFFDF5',
                            100: '#FEF9E7',
                            200: '#FDF0C4',
                            300: '#FCE496',
                            400: '#FAD563',
                            500: '#E5A93C',
                            600: '#D9941E',
                            700: '#B87514',
                            800: '#945B13',
                            900: '#7A4A13',
                        },
                        'brand-dark': '#1C1B19',
                        'brand-muted': '#6B6862',
                    },
                    boxShadow: {
                        'soft': '0 1px 2px rgba(28,27,25,.04), 0 8px 24px -12px rgba(28,27,25,.12)',
                        'card-hover': '0 2px 6px rgba(28,27,25,.06), 0 18px 40px -18px rgba(28,27,25,.22)',
                    },
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Sora', sans-serif;
            background-color: #FBFBFA;
            color: #1C1B19;
            overflow-x: hidden;
        }

        .glass-nav {
            background: rgba(251, 251, 250, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24;
        }
    </style>

    <!-- Scroll reveal: CSS + JS dimuat di head agar tidak ada flicker.
         reveal.js tidak pakai defer secara sengaja, lihat komentar di file. -->
    <link rel="stylesheet" href="{{ asset('css/reveal.css') }}">
    <script src="{{ asset('js/reveal.js') }}"></script>

    @stack('styles')
</head>

<body class="bg-off-white text-brand-dark antialiased">

    <header class="fixed top-0 left-0 right-0 z-50 glass-nav border-b border-warm-beige/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <a href="{{ route('user.beranda') }}"
                   class="text-xl font-bold tracking-tight hover:text-butter-gold-600 transition-colors duration-300">
                    S'Spotlight
                    <span class="inline-block w-2 h-2 rounded-full bg-butter-gold-500"></span>
                </a>

                <nav class="hidden md:flex items-center gap-1 bg-warm-beige-light/70 p-1.5 rounded-full border border-warm-beige">

    @foreach([
        ['route' => 'user.beranda', 'label' => 'Beranda'],
        ['route' => 'user.portofolio', 'label' => 'Portofolio'],
        ['route' => 'user.galeri', 'label' => 'Galeri'],
        ['route' => 'user.infoumum', 'label' => 'Info Umum'],
        ['route' => 'user.profil', 'label' => 'Profil'],
    ] as $menu)

        <a href="{{ route($menu['route']) }}"
           class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300
           {{ request()->routeIs($menu['route'])
               ? 'bg-butter-gold-400 text-brand-dark shadow-sm'
               : 'text-brand-muted hover:text-brand-dark hover:bg-white/80' }}">
            {{ $menu['label'] }}
        </a>

    @endforeach

</nav>
<!-- Hamburger Mobile -->
<button
    id="mobile-menu-button"
    type="button"
    class="md:hidden flex items-center justify-center w-10 h-10 rounded-xl border border-warm-beige hover:bg-warm-beige-light transition"
    aria-label="Buka menu"
    aria-expanded="false"
>
    <span class="material-symbols-outlined">menu</span>
</button>
                <a href="{{ route('user.portofolio') }}"
                   class="hidden lg:inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-brand-dark text-white hover:bg-butter-gold-600 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                    Lihat Karya
                    <span class="material-symbols-outlined text-sm">arrow_outward</span>
                </a>
            </div>

            <!-- Menu Mobile -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <nav class="flex flex-col gap-1 bg-warm-beige-light/70 p-2 rounded-2xl border border-warm-beige">

                    @foreach([
                        ['route' => 'user.beranda', 'label' => 'Beranda'],
                        ['route' => 'user.portofolio', 'label' => 'Portofolio'],
                        ['route' => 'user.galeri', 'label' => 'Galeri'],
                        ['route' => 'user.infoumum', 'label' => 'Info Umum'],
                        ['route' => 'user.profil', 'label' => 'Profil'],
                    ] as $menu)

                        <a href="{{ route($menu['route']) }}"
                           class="px-4 py-3 rounded-xl text-sm font-medium
                           {{ request()->routeIs($menu['route'])
                               ? 'bg-butter-gold-400 text-brand-dark'
                               : 'text-brand-muted hover:bg-white/80' }}">
                            {{ $menu['label'] }}
                        </a>

                    @endforeach

                    <a href="{{ route('user.portofolio') }}"
                       class="mt-1 px-4 py-3 rounded-xl text-sm font-bold text-center bg-brand-dark text-white">
                        Lihat Karya
                    </a>

                </nav>
            </div>

        </div>
    </header>

    <main class="pt-24 lg:pt-28">
        @yield('content')
    </main>

    <footer class="bg-warm-beige border-t border-warm-beige/80 text-brand-dark pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 lg:gap-8 pb-12 border-b border-brand-dark/10">
                
                <!-- Col 1: Brand Info (5 cols) -->
                <div class="lg:col-span-5" data-reveal="left">
                    <a href="{{ route('user.beranda') }}" class="flex items-center gap-2.5 mb-4">
                        <span class="w-9 h-9 rounded-xl bg-butter-gold-500 text-white flex items-center justify-center font-extrabold text-lg shadow-sm">
                            S'
                        </span>
                        <span class="text-2xl font-bold tracking-tight text-brand-dark">
                            S'Spotlight
                        </span>
                    </a>
                    <p class="text-sm font-semibold text-butter-gold-800 mb-2">
                        Setiap Karya Punya Ruang
                    </p>
                    <p class="text-sm text-brand-muted leading-relaxed max-w-sm mb-6">
                        Platform wadah apresiasi, dokumentasi portofolio, dan inovasi siswa SMK Negeri 2 Purwakarta.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="https://smkn2pwk.sch.id/" target="_blank" class="w-9 h-9 rounded-xl bg-white/80 hover:bg-white text-brand-dark flex items-center justify-center shadow-sm hover:text-butter-gold-600 transition-colors" title="Website Resmi">
                            <span class="material-symbols-outlined text-lg">language</span>
                        </a>
                        <a href="mailto:smkn2.purwakarta@yahoo.com" class="w-9 h-9 rounded-xl bg-white/80 hover:bg-white text-brand-dark flex items-center justify-center shadow-sm hover:text-butter-gold-600 transition-colors" title="Email Kami">
                            <span class="material-symbols-outlined text-lg">mail</span>
                        </a>
                    </div>
                </div>

                <!-- Col 2: Quick Links (3 cols) -->
                <div class="lg:col-span-3" data-reveal>
                    <h4 class="font-bold text-sm uppercase tracking-wider text-brand-dark mb-4">
                        Tautan Cepat
                    </h4>
                    <ul class="space-y-2.5 text-sm text-brand-muted">
                        <li>
                            <a href="{{ route('user.beranda') }}" class="hover:text-butter-gold-800 transition-colors flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-xs">chevron_right</span>
                                <span>Beranda</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.portofolio') }}" class="hover:text-butter-gold-800 transition-colors flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-xs">chevron_right</span>
                                <span>Koleksi Portofolio</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.galeri') }}" class="hover:text-butter-gold-800 transition-colors flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-xs">chevron_right</span>
                                <span>Galeri Momen</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.infoumum') }}" class="hover:text-butter-gold-800 transition-colors flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-xs">chevron_right</span>
                                <span>Info &amp; Pengumuman</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.profil') }}" class="hover:text-butter-gold-800 transition-colors flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-xs">chevron_right</span>
                                <span>Profil Pengembang</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Contact & Address (4 cols) -->
                <div class="lg:col-span-4" data-reveal="right">
                    <h4 class="font-bold text-sm uppercase tracking-wider text-brand-dark mb-4">
                        SMKN 2 Purwakarta
                    </h4>
                    <div class="space-y-3 text-sm text-brand-muted">
                        <div class="flex items-start gap-3">
                            <span class="material-symbols-outlined text-butter-gold-700 text-lg mt-0.5">location_on</span>
                            <span>
                                Jl. Jend. Ahmad Yani No.98, Nagri Tengah, Kec. Purwakarta, Kabupaten Purwakarta, Jawa Barat 41114
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-butter-gold-700 text-lg">call</span>
                            <span>(0264) 200724</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-butter-gold-700 text-lg">mail</span>
                            <span>smkn2.purwakarta@yahoo.com</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Copyright Line -->
            <div data-reveal="fade" class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-brand-muted">
                <p>
                    &copy; 2026 S'Spotlight. Dibuat oleh <strong>Nur Afni Herawati</strong> — SMKN 2 Purwakarta.
                </p>
                <p class="flex items-center gap-1">
                    <span>Setiap Karya Punya Ruang</span>
                    <span class="material-symbols-outlined text-sm text-butter-gold-600 fill">favorite</span>
                </p>
            </div>

        </div>
    </footer>


    @stack('scripts')

    <script>
    (function () {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (!menuButton || !mobileMenu) return;

        const icon = menuButton.querySelector('span');

        function setMenu(open) {
            mobileMenu.classList.toggle('hidden', !open);
            menuButton.setAttribute('aria-expanded', String(open));
            if (icon) icon.textContent = open ? 'close' : 'menu';
        }

        menuButton.addEventListener('click', function () {
            setMenu(mobileMenu.classList.contains('hidden'));
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setMenu(false);
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) setMenu(false);
        });
    })();
</script>

</body>
</html>