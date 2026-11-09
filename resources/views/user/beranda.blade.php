<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'Spotlight — Setiap Karya Punya Ruang | SMKN 2 Purwakarta</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Sora:wght@100..800&family=Space+Grotesk:wght@300..700&family=Square+Peg&display=swap" rel="stylesheet">

    <!-- Material Symbols Outlined -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Tailwind CSS with custom configuration -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Sora', 'sans-serif'],
                    },
                    colors: {
                        'off-white': '#FBFBFA',
                        'off-white-alt': '#F9F9FF',
                        'warm-beige': '#E7E2D6',
                        'warm-beige-light': '#F4F0E8',
                        'butter-gold': {
                            50: '#FFFDF5',
                            100: '#FEF9E7',
                            200: '#FDF0C4',
                            300: '#FCE496',
                            400: '#FAD563',
                            500: '#E5A93C', // Primary Gold
                            600: '#D9941E',
                            700: '#B87514',
                            800: '#945B13',
                            900: '#7A4A13',
                        },
                        'brand-dark': '#1C1B19',
                        'brand-muted': '#6B6862',
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(28, 27, 25, 0.05)',
                        'gold-glow': '0 10px 30px -5px rgba(229, 169, 60, 0.25)',
                        'card-hover': '0 20px 35px -5px rgba(28, 27, 25, 0.08), 0 10px 15px -5px rgba(229, 169, 60, 0.05)',
                    }
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

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            vertical-align: middle;
            line-height: 1;
        }

        .material-symbols-outlined.fill {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Smooth glassmorphism */
        .glass-nav {
            background: rgba(251, 251, 250, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
        }

        /* Subtle radial glow */
        .hero-glow {
            background: radial-gradient(circle at 50% 30%, rgba(250, 213, 99, 0.18) 0%, rgba(251, 251, 250, 0) 70%);
        }
    </style>

    <!-- Scroll reveal: CSS + JS dimuat di head agar tidak ada flicker.
         reveal.js sengaja tanpa defer, lihat komentar di dalam file. -->
    <link rel="stylesheet" href="{{ asset('css/reveal.css') }}">
    <script src="{{ asset('js/reveal.js') }}"></script>
</head>

<body class="bg-off-white text-brand-dark antialiased selection:bg-butter-gold-200 selection:text-brand-dark">

    @php
        $portfolioList = $portofolios ?? $portofolio ?? [];
        $galeriList = $galeris ?? $galeri ?? [];
        $infoList = $infos ?? $informasi ?? [];
    @endphp

    <!-- =========================================================
         1. NAVBAR (Fixed Top)
         ========================================================= -->
    <header class="fixed top-0 left-0 right-0 z-50 glass-nav border-b border-warm-beige/60 transition-all duration-300" id="main-header">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo -->
                <a href="{{ route('user.beranda') }}" class="flex items-center gap-2.5 group">

                    <div class="flex flex-col">
                        <span class="text-xl font-bold tracking-tight text-brand-dark flex items-center gap-1">
                            S'Spotlight
                            <span class="w-2 h-2 rounded-full bg-butter-gold-500 animate-pulse"></span>
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Menu -->
                <nav class="hidden md:flex items-center gap-1 bg-warm-beige-light/70 p-1.5 rounded-full border border-warm-beige">
                    <a href="{{ route('user.beranda') }}" class="px-5 py-2 rounded-full text-sm font-semibold bg-butter-gold-500 text-white shadow-sm shadow-butter-gold-500/30 transition-all">
                        Beranda
                    </a>
                    <a href="{{ route('user.portofolio') }}" class="px-5 py-2 rounded-full text-sm font-medium text-brand-muted hover:text-brand-dark hover:bg-white/80 transition-all">
                        Portofolio
                    </a>
                    <a href="{{ route('user.galeri') }}" class="px-5 py-2 rounded-full text-sm font-medium text-brand-muted hover:text-brand-dark hover:bg-white/80 transition-all">
                        Galeri
                    </a>
                    <a href="{{ route('user.infoumum') }}" class="px-5 py-2 rounded-full text-sm font-medium text-brand-muted hover:text-brand-dark hover:bg-white/80 transition-all">
                        Info Umum
                    </a>
                    <a href="{{ route('user.profil') }}" class="px-5 py-2 rounded-full text-sm font-medium text-brand-muted hover:text-brand-dark hover:bg-white/80 transition-all">
                        Profil
                    </a>
                </nav>

                <!-- Right Action / Mobile Hamburger -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.portofolio') }}" class="hidden lg:inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-brand-dark text-white hover:bg-butter-gold-600 transition-colors shadow-sm">
                        <span>Lihat Karya</span>
                        <span class="material-symbols-outlined text-sm">arrow_outward</span>
                    </a>

                    <!-- Hamburger Button -->
                    <button id="mobile-menu-btn" type="button" class="md:hidden p-2.5 rounded-xl bg-warm-beige-light border border-warm-beige text-brand-dark hover:bg-warm-beige transition-colors" aria-label="Buka Menu" aria-expanded="false">
                        <span class="material-symbols-outlined text-2xl" id="menu-icon">menu</span>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-off-white border-b border-warm-beige px-6 py-5 transition-all">
            <div class="flex flex-col gap-2">
                <a href="{{ route('user.beranda') }}" class="flex items-center justify-between px-4 py-3 rounded-xl bg-butter-gold-500 text-white font-semibold text-sm">
                    <span>Beranda</span>
                    <span class="material-symbols-outlined text-sm">check</span>
                </a>
                <a href="{{ route('user.portofolio') }}" class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-warm-beige-light text-brand-dark font-medium text-sm">
                    <span>Portofolio</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
                <a href="{{ route('user.galeri') }}" class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-warm-beige-light text-brand-dark font-medium text-sm">
                    <span>Galeri Momen</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
                <a href="{{ route('user.infoumum') }}" class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-warm-beige-light text-brand-dark font-medium text-sm">
                    <span>Info Umum</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
                <a href="{{ route('user.profil') }}" class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-warm-beige-light text-brand-dark font-medium text-sm">
                    <span>Profil Sekolah</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </div>
    </header>


    <main class="pt-20">

        <!-- =========================================================
     2. HERO SECTION
     ========================================================= -->
<section class="relative min-h-[calc(100vh-5rem)] flex items-center overflow-hidden hero-glow py-16 md:py-24 border-b border-warm-beige/40">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Text Content (Centered Layout) -->
        <div class="flex flex-col items-center text-center" data-reveal-group="fade">
            
            <!-- Tagline Pill -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-butter-gold-100 border border-butter-gold-300/80 text-butter-gold-800 text-xs font-bold tracking-wider uppercase mb-6 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-butter-gold-500 animate-ping"></span>
                <span class="material-symbols-outlined text-base text-butter-gold-600">stars</span>
                WADAH APRESIASI KARYA SISWA
            </div>

            <!-- Headline -->
            <h1 class="text-3xl sm:text-4xl lg:text-6xl font-extrabold text-brand-dark tracking-tight leading-[1.15] mb-6">
                Setiap Karya <br class="hidden sm:inline">
                <span class="relative inline-block text-transparent bg-clip-text bg-gradient-to-r from-butter-gold-600 via-butter-gold-500 to-amber-600">
                    Punya Ruang
                    <svg class="absolute -bottom-2 left-0 w-full h-3 text-butter-gold-400 -z-10" viewBox="0 0 100 20" preserveAspectRatio="none">
                        <path d="M0,15 Q50,0 100,15" stroke="currentColor" stroke-width="6" fill="none" stroke-linecap="round" />
                    </svg>
                </span>
            </h1>

            <!-- Sub-headline -->
            <p class="text-base sm:text-lg text-brand-muted font-normal leading-relaxed max-w-2xl mb-8 mx-auto">
                S'Spotlight hadir sebagai ruang apresiasi untuk semua ide, proses, dan karya siswa <strong>SMKN 2 Purwakarta</strong>. <br>Apapun bentuk karyamu, tunjukkan di sini.
            </p>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto">
                <a href="#koleksi-karya" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-7 py-3.5 rounded-2xl bg-butter-gold-500 text-white font-bold text-base shadow-gold-glow hover:bg-butter-gold-600 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    <span class="material-symbols-outlined text-xl">auto_awesome</span>
                    <span>Jelajahi Karya</span>
                </a>

                <a href="#" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-2xl bg-white border-2 border-warm-beige text-brand-dark font-semibold text-base hover:bg-warm-beige-light hover:border-butter-gold-300 transition-all">
                    <span class="material-symbols-outlined text-xl text-butter-gold-600">add_circle</span>
                    <span>Ajukan Karyamu</span>
                </a>
            </div>

        </div>

    </div>
</section>

        <!-- =========================================================
             3. KOLEKSI KARYA SISWA SECTION
             ========================================================= -->
        <section class="py-14 sm:py-20 bg-off-white" id="koleksi-karya">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10" data-reveal>
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-butter-gold-700 text-xs font-bold uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-sm">grid_view</span>
                            Showcase Portofolio
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-dark tracking-tight">
                            Koleksi Karya Siswa
                        </h2>
                        <p class="text-brand-muted text-sm sm:text-base mt-2 max-w-xl">
                            Eksplorasi inovasi digital, desain grafis, aplikasi, dan karya kreatif buatan siswa SMKN 2 Purwakarta.
                        </p>
                    </div>

                    <a href="{{ route('user.portofolio') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-warm-beige text-brand-dark font-semibold text-sm hover:border-butter-gold-500 hover:text-butter-gold-700 transition-all shadow-soft group">
                        <span>Lihat Semua Karya</span>
                        <span class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>

                <!-- Category Filter Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-3 mb-10 no-scrollbar" id="portfolio-filters" data-reveal="fade">
                    <button type="button" data-filter="all" class="portfolio-filter-btn active px-5 py-2 rounded-full text-xs sm:text-sm font-semibold bg-butter-gold-500 text-white shadow-sm transition-all whitespace-nowrap">
                        Semua
                    </button>
                    <button type="button" data-filter="web" class="portfolio-filter-btn px-5 py-2 rounded-full text-xs sm:text-sm font-semibold bg-white border border-warm-beige text-brand-muted hover:text-brand-dark hover:border-butter-gold-400 transition-all whitespace-nowrap">
                        Web
                    </button>
                    <button type="button" data-filter="apk" class="portfolio-filter-btn px-5 py-2 rounded-full text-xs sm:text-sm font-semibold bg-white border border-warm-beige text-brand-muted hover:text-brand-dark hover:border-butter-gold-400 transition-all whitespace-nowrap">
                        Aplikasi
                    </button>
                    <button type="button" data-filter="desain" class="portfolio-filter-btn px-5 py-2 rounded-full text-xs sm:text-sm font-semibold bg-white border border-warm-beige text-brand-muted hover:text-brand-dark hover:border-butter-gold-400 transition-all whitespace-nowrap">
                        Desain
                    </button>
                    <button type="button" data-filter="gambar" class="portfolio-filter-btn px-5 py-2 rounded-full text-xs sm:text-sm font-semibold bg-white border border-warm-beige text-brand-muted hover:text-brand-dark hover:border-butter-gold-400 transition-all whitespace-nowrap">
                        Gambar
                    </button>
                </div>

                <!-- Portfolio Grid (3 Columns) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-8" id="portfolio-cards-grid" data-reveal-group>
                    @forelse ($portfolioList as $portfolio)
                        @php
                            $cat = strtolower($portfolio->kategori ?? 'web');
                            // Map category badge styling
                            $badgeClass = 'bg-butter-gold-100 text-butter-gold-900 border-butter-gold-300';
                            if (str_contains($cat, 'web')) {
                                $badgeClass = 'bg-blue-50 text-blue-800 border-blue-200';
                            } elseif (str_contains($cat, 'apk') || str_contains($cat, 'aplikasi')) {
                                $badgeClass = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                            } elseif (str_contains($cat, 'desain')) {
                                $badgeClass = 'bg-purple-50 text-purple-800 border-purple-200';
                            } elseif (str_contains($cat, 'gambar')) {
                                $badgeClass = 'bg-amber-50 text-amber-800 border-amber-200';
                            }
                        @endphp
                        
                        <article class="portfolio-card-item bg-white rounded-2xl border border-warm-beige overflow-hidden shadow-soft hover:shadow-card-hover transition-all duration-300 flex flex-col group" data-category="{{ $cat }}">
                            
                            <!-- Card Image & Badge -->
                            <div class="relative aspect-[16/10] bg-warm-beige-light overflow-hidden">
                                @if (!empty($portfolio->gambar))
                                    <img 
                                        src="{{ asset('image/'.$portfolio->gambar) }}" 
                                        alt="{{ $portfolio->nama_portofolio }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy"
                                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?auto=format&fit=crop&w=600&q=80';"
                                    >
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-warm-beige-light to-butter-gold-100/50 text-brand-muted">
                                        <span class="material-symbols-outlined text-4xl text-butter-gold-500 mb-1">palette</span>
                                        <span class="text-xs font-semibold">Pratinjau Karya</span>
                                    </div>
                                @endif

                                <!-- Category Badge at top-left of image -->
                                <div class="absolute top-3.5 left-3.5">
                                    <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider backdrop-blur-md border shadow-sm {{ $badgeClass }}">
                                        {{ $portfolio->kategori ?? 'Karya Siswa' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 flex flex-col flex-1 justify-between">
                                <div>
                                    <h3 class="font-bold text-lg text-brand-dark group-hover:text-butter-gold-600 transition-colors line-clamp-1">
                                        {{ $portfolio->nama_portofolio }}
                                    </h3>
                                    
                                    @if (!empty($portfolio->deskripsi))
                                        <p class="text-brand-muted text-xs sm:text-sm mt-2 line-clamp-2 leading-relaxed">
                                            {{ strip_tags($portfolio->deskripsi) }}
                                        </p>
                                    @endif
                                </div>

                                <div class="mt-5 pt-4 border-t border-warm-beige/80 flex items-center justify-between">
                                    <!-- Student Name -->
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-butter-gold-100 text-butter-gold-800 flex items-center justify-center font-bold text-xs">
                                            <span class="material-symbols-outlined text-sm">person</span>
                                        </div>
                                        <span class="text-xs font-semibold text-brand-dark line-clamp-1">
                                            {{ $portfolio->nama_siswa ?? 'Siswa SMKN 2' }}
                                        </span>
                                    </div>

                                    <!-- Detail Link -->
                                    <a href="{{ route('user.detailporto', $portfolio->id_portofolio) }}" class="p-1.5 rounded-lg text-brand-muted hover:text-butter-gold-600 hover:bg-butter-gold-50 transition-colors" title="Lihat Detail">
                                        <span class="material-symbols-outlined text-xl">arrow_forward</span>
                                    </a>
                                </div>

                            </div>

                        </article>
                    @empty
                        <div class="col-span-full py-16 px-6 text-center bg-white rounded-3xl border border-dashed border-warm-beige">
                            <span class="material-symbols-outlined text-5xl text-butter-gold-400 mb-3">folder_open</span>
                            <h3 class="text-lg font-bold text-brand-dark">Belum Ada Portofolio Ditampilkan</h3>
                            <p class="text-brand-muted text-sm mt-1 max-w-sm mx-auto">Karya siswa akan segera dipublikasikan di sini.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </section>


        <!-- =========================================================
             4. MOMEN SEKOLAH (GALERI FOTO) SECTION
             ========================================================= -->
        <section class="py-14 sm:py-20 bg-warm-beige-light/50 border-y border-warm-beige/70" id="momen-sekolah">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12" data-reveal>
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-butter-gold-700 text-xs font-bold uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-sm">photo_library</span>
                            Dokumentasi Visual
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-dark tracking-tight">
                            Momen Sekolah
                        </h2>
                        <p class="text-brand-muted text-sm sm:text-base mt-2 max-w-xl">
                            Dokumentasi kegiatan, pameran karya, dan kebersamaan di SMKN 2 Purwakarta.
                        </p>
                    </div>

                    <a href="{{ route('user.galeri') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-warm-beige text-brand-dark font-semibold text-sm hover:border-butter-gold-500 hover:text-butter-gold-700 transition-all shadow-soft group">
                        <span>Lihat Galeri Lengkap</span>
                        <span class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>

                <!-- 3 Photo Cards Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" data-reveal-group="scale">
                    @forelse ($galeriList as $index => $galeri)
                        <div class="group relative rounded-3xl overflow-hidden bg-white border border-warm-beige shadow-soft hover:shadow-card-hover transition-all duration-300">
                            
                            <div class="aspect-[4/3] w-full overflow-hidden bg-warm-beige">
                                @if (!empty($galeri->gambar))
                                    <img 
                                        src="{{ asset('image/'.$galeri->gambar) }}" 
                                        alt="{{ $galeri->judul ?? 'Momen SMKN 2 Purwakarta' }}"
                                        class="w-full h-full object-cover group-hover:scale-105 group-hover:rotate-1 transition-transform duration-700"
                                        loading="lazy"
                                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=600&q=80';"
                                    >
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-tr from-warm-beige to-butter-gold-100 text-brand-muted">
                                        <span class="material-symbols-outlined text-4xl text-butter-gold-500 mb-1">image</span>
                                        <span class="text-xs font-semibold">Foto Dokumentasi</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Gradient Overlay & Info -->
                            <div class="p-5 bg-white flex flex-col justify-between">
                                <h3 class="font-bold text-base text-brand-dark group-hover:text-butter-gold-600 transition-colors line-clamp-1">
                                    {{ $galeri->judul ?? 'Dokumentasi Sekolah' }}
                                </h3>
                                <div class="flex items-center gap-1.5 text-xs text-brand-muted mt-2">
                                    <span class="material-symbols-outlined text-sm text-butter-gold-600">location_on</span>
                                    <span>SMKN 2 Purwakarta</span>
                                </div>
                            </div>

                        </div>
                    @empty
                        <div class="col-span-full py-16 px-6 text-center bg-white rounded-3xl border border-dashed border-warm-beige">
                            <span class="material-symbols-outlined text-5xl text-butter-gold-400 mb-3">collections</span>
                            <h3 class="text-lg font-bold text-brand-dark">Belum Ada Foto Dokumentasi</h3>
                            <p class="text-brand-muted text-sm mt-1 max-w-sm mx-auto">Foto kegiatan pameran dan karya akan segera diunggah.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </section>


        <!-- =========================================================
             5. INFO & PENGUMUMAN SECTION
             ========================================================= -->
        <section class="py-14 sm:py-20 bg-off-white" id="info-pengumuman">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <!-- Section Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10" data-reveal>
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-butter-gold-700 text-xs font-bold uppercase tracking-wider mb-2">
                            <span class="material-symbols-outlined text-sm">campaign</span>
                            Warta &amp; Kabar
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-dark tracking-tight">
                            Info &amp; Pengumuman
                        </h2>
                        <p class="text-brand-muted text-sm sm:text-base mt-2 max-w-xl">
                            Informasi resmi seputar agenda pameran, kompetisi, pengumuman sekolah, dan berita terkini.
                        </p>
                    </div>

                    <a href="{{ route('user.infoumum') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white border border-warm-beige text-brand-dark font-semibold text-sm hover:border-butter-gold-500 hover:text-butter-gold-700 transition-all shadow-soft group">
                        <span>Lihat Semua Info</span>
                        <span class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>

                <!-- Info Filter Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-3 mb-8 no-scrollbar" id="info-filters" data-reveal="fade">
                    <button type="button" data-filter="all" class="info-filter-btn active px-5 py-2 rounded-full text-xs sm:text-sm font-semibold bg-butter-gold-500 text-white shadow-sm transition-all whitespace-nowrap">
                        Semua
                    </button>
                    <button type="button" data-filter="berita" class="info-filter-btn px-5 py-2 rounded-full text-xs sm:text-sm font-semibold bg-white border border-warm-beige text-brand-muted hover:text-brand-dark hover:border-butter-gold-400 transition-all whitespace-nowrap">
                        Berita
                    </button>
                    <button type="button" data-filter="pengumuman" class="info-filter-btn px-5 py-2 rounded-full text-xs sm:text-sm font-semibold bg-white border border-warm-beige text-brand-muted hover:text-brand-dark hover:border-butter-gold-400 transition-all whitespace-nowrap">
                        Pengumuman
                    </button>
                </div>

                <!-- 3 Horizontal Announcement Cards -->
                <div class="space-y-4" id="info-cards-container">
                    @forelse ($infoList as $info)
                        @php
                            $infoCat = strtolower($info->kategori ?? 'berita');
                            $isBerita = str_contains($infoCat, 'berita');
                        @endphp

                        <article class="info-card-item bg-white rounded-2xl border border-warm-beige p-5 sm:p-6 shadow-soft hover:shadow-card-hover hover:border-butter-gold-300 transition-all duration-300 flex flex-col md:flex-row gap-6 items-start md:items-center group" data-category="{{ $infoCat }}">
                            
                            <!-- Optional Thumbnail / Icon -->
                            <div class="w-full md:w-44 h-36 md:h-28 rounded-xl overflow-hidden bg-warm-beige-light flex-shrink-0 relative">
                                @if (!empty($info->gambar))
                                    <img 
                                        src="{{ asset('image/'.$info->gambar) }}" 
                                        alt="{{ $info->judul }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        loading="lazy"
                                        onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=400&q=80';"
                                    >
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center bg-butter-gold-50 text-butter-gold-700">
                                        <span class="material-symbols-outlined text-3xl">feed</span>
                                        <span class="text-[10px] font-bold uppercase mt-1">S'Spotlight</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Content Column -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-3 mb-2">
                                    <!-- Type Badge -->
                                    <span class="px-3 py-0.5 rounded-md text-[11px] font-bold uppercase tracking-wider {{ $isBerita ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $info->kategori ?? 'INFO' }}
                                    </span>

                                    <!-- Date -->
                                    <span class="text-xs font-medium text-brand-muted flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                                        {{ $info->tanggal ? \Carbon\Carbon::parse($info->tanggal)->translatedFormat('d F Y') : ($info->created_at ? $info->created_at->translatedFormat('d F Y') : 'Terbaru') }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h3 class="font-bold text-lg text-brand-dark group-hover:text-butter-gold-600 transition-colors line-clamp-1">
                                    {{ $info->judul }}
                                </h3>

                                <!-- Snippet -->
                                <p class="text-brand-muted text-xs sm:text-sm mt-1.5 line-clamp-2 leading-relaxed">
                                    {{ Str::limit(strip_tags($info->isi), 140) }}
                                </p>
                            </div>

                            <!-- Action Button -->
                            <div class="self-end md:self-center flex-shrink-0">
                                <a href="{{ route('user.infoumum') }}" class="inline-flex items-center gap-1 px-4 py-2 rounded-xl bg-warm-beige-light text-brand-dark font-semibold text-xs hover:bg-butter-gold-500 hover:text-white transition-colors">
                                    <span>Baca</span>
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            </div>

                        </article>
                    @empty
                        <div class="py-12 px-6 text-center bg-white rounded-3xl border border-dashed border-warm-beige">
                            <span class="material-symbols-outlined text-4xl text-butter-gold-400 mb-2">info</span>
                            <h3 class="text-base font-bold text-brand-dark">Belum Ada Informasi Terbaru</h3>
                            <p class="text-brand-muted text-xs mt-1">Pengumuman sekolah akan ditampilkan di sini.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </section>


        <!-- =========================================================
             6. INSTITUTIONAL INFO & CORE VALUES
             ========================================================= -->
        <section class="py-24 bg-gradient-to-b from-off-white to-warm-beige-light/40 border-t border-warm-beige" id="tentang">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center mb-16">
                    
                    <!-- Institutional Summary -->
                    <div class="lg:col-span-7" data-reveal="left">
                        <div class="inline-flex items-center gap-1.5 text-butter-gold-700 text-xs font-bold uppercase tracking-wider mb-3">
                            <span class="material-symbols-outlined text-sm">domain</span>
                            Tentang Platform
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-brand-dark tracking-tight leading-tight mb-5">
                            Membangun Ruang Kreatif Bersama S'Spotlight
                        </h2>
                        <p class="text-brand-muted text-base leading-relaxed mb-4">
                            <strong>S'Spotlight</strong> merupakan platform portofolio dan ruang apresiasi digital resmi yang didedikasikan bagi siswa-siswi <strong>SMK Negeri 2 Purwakarta</strong>. Kami percaya bahwa setiap ide, baris kode, guratan desain, dan karya inovatif layak mendapatkan panggung yang menginspirasi.
                        </p>
                        <p class="text-brand-muted text-base leading-relaxed mb-8">
                            Melalui ekosistem ini, karya siswa tidak hanya terdokumentasi rapi sebagai jejak rekam prestasi, tetapi juga siap diakses oleh dunia industri, alumni, dan masyarakat luas.
                        </p>

                        <!-- External Button to SMKN 2 Purwakarta Official Website -->
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="https://smkn2pwk.sch.id/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-2xl bg-brand-dark text-white font-bold text-sm hover:bg-butter-gold-600 transition-all shadow-md group">
                                <span class="material-symbols-outlined text-lg text-butter-gold-400 group-hover:text-white">language</span>
                                <span>Kunjungi Website Resmi SMKN 2 Purwakarta</span>
                                <span class="material-symbols-outlined text-sm group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform">open_in_new</span>
                            </a>
                            <a href="{{ route('user.profil') }}" class="inline-flex items-center gap-2 px-5 py-3.5 rounded-2xl bg-white border border-warm-beige text-brand-dark font-semibold text-sm hover:bg-warm-beige transition-all">
                                <span>Profil Pengembang</span>
                            </a>
                        </div>
                    </div>

                    <!-- Visual Accent Card -->
                    <div class="lg:col-span-5" data-reveal="right">
                        <div class="bg-white rounded-3xl p-8 border border-warm-beige shadow-card-hover relative overflow-hidden">
                            <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-butter-gold-100 rounded-full blur-2xl -z-10"></div>
                            
                            <div class="w-14 h-14 rounded-2xl bg-butter-gold-500 text-white flex items-center justify-center font-extrabold text-2xl shadow-md shadow-butter-gold-500/30 mb-6">
                                <span class="material-symbols-outlined text-3xl">school</span>
                            </div>

                            <h3 class="text-xl font-bold text-brand-dark mb-2">SMKN 2 Purwakarta</h3>
                            <p class="text-sm text-brand-muted leading-relaxed mb-6">
                                Sekolah Menengah Kejuruan Pusat Keunggulan yang berkomitmen mencetak generasi profesional, kreatif, berakhlak mulia, dan siap bersaing di era digital.
                            </p>

                            <div class="space-y-3 border-t border-warm-beige/80 pt-5 text-xs text-brand-muted">
                                <div class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-sm text-butter-gold-600">location_on</span>
                                    <span>Jl. Jend. Ahmad Yani No. 98, Purwakarta</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="material-symbols-outlined text-sm text-butter-gold-600">verified</span>
                                    <span>Pusat Keunggulan &amp; Kreativitas Vokasi</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 3 Core Value Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-8" data-reveal-group>
                    
                    <!-- Card 1: Apresiasi -->
                    <div class="bg-white rounded-3xl p-5 sm:p-8 border border-warm-beige shadow-soft hover:shadow-card-hover hover:border-butter-gold-400 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-butter-gold-100 text-butter-gold-700 flex items-center justify-center mb-4 sm:mb-6 group-hover:bg-butter-gold-500 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-3xl">military_tech</span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-brand-dark mb-3">Apresiasi</h3>
                            <p class="text-brand-muted text-sm leading-relaxed">
                                Memberikan ruang dan pengakuan tulus bagi setiap usaha, kreasi, dan pencapaian siswa agar selalu termotivasi menghasilkan yang terbaik.
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-6 pt-3 sm:pt-4 border-t border-warm-beige/60 text-xs font-semibold text-butter-gold-700 flex items-center gap-1">
                            <span>Menghargai Proses</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </div>
                    </div>

                    <!-- Card 2: Inspirasi -->
                    <div class="bg-white rounded-3xl p-5 sm:p-8 border border-warm-beige shadow-soft hover:shadow-card-hover hover:border-butter-gold-400 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center mb-4 sm:mb-6 group-hover:bg-butter-gold-500 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-3xl">lightbulb</span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-brand-dark mb-3">Inspirasi</h3>
                            <p class="text-brand-muted text-sm leading-relaxed">
                                Menjadi sumber rujukan dan pemantik semangat bagi adik kelas dan sesama siswa untuk terus bereksplorasi dan berinovasi tanpa batas.
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-6 pt-3 sm:pt-4 border-t border-warm-beige/60 text-xs font-semibold text-butter-gold-700 flex items-center gap-1">
                            <span>Memicu Gagasan Baru</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </div>
                    </div>

                    <!-- Card 3: Kolaborasi -->
                    <div class="bg-white rounded-3xl p-5 sm:p-8 border border-warm-beige shadow-soft hover:shadow-card-hover hover:border-butter-gold-400 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-2xl bg-orange-100 text-orange-800 flex items-center justify-center mb-4 sm:mb-6 group-hover:bg-butter-gold-500 group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-3xl">hub</span>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-brand-dark mb-3">Kolaborasi</h3>
                            <p class="text-brand-muted text-sm leading-relaxed">
                                Menjembatani sinergi lintas kompetensi keahlian dan menghubungkan karya nyata siswa dengan dunia profesional dan industri.
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-6 pt-3 sm:pt-4 border-t border-warm-beige/60 text-xs font-semibold text-butter-gold-700 flex items-center gap-1">
                            <span>Sinergi Bersama</span>
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main>


    <!-- =========================================================
         7. FOOTER
         ========================================================= -->
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


    <!-- =========================================================
         INTERACTIVE CLIENT-SIDE JAVASCRIPT
         ========================================================= -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile Menu Toggle
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuIcon = document.getElementById('menu-icon');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', () => {
                    const isHidden = mobileMenu.classList.contains('hidden');
                    if (isHidden) {
                        mobileMenu.classList.remove('hidden');
                        menuIcon.textContent = 'close';
                        menuBtn.setAttribute('aria-expanded', 'true');
                    } else {
                        mobileMenu.classList.add('hidden');
                        menuIcon.textContent = 'menu';
                        menuBtn.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            // Portfolio Filter Pills Interactivity
            const portfolioFilters = document.querySelectorAll('.portfolio-filter-btn');
            const portfolioCards = document.querySelectorAll('.portfolio-card-item');

            portfolioFilters.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Update active button classes
                    portfolioFilters.forEach(b => {
                        b.classList.remove('bg-butter-gold-500', 'text-white', 'shadow-sm', 'active');
                        b.classList.add('bg-white', 'border', 'border-warm-beige', 'text-brand-muted');
                    });
                    btn.classList.remove('bg-white', 'border', 'border-warm-beige', 'text-brand-muted');
                    btn.classList.add('bg-butter-gold-500', 'text-white', 'shadow-sm', 'active');

                    const filterValue = btn.getAttribute('data-filter');

                    portfolioCards.forEach(card => {
                        const cardCat = card.getAttribute('data-category') || '';
                        if (filterValue === 'all' || cardCat.includes(filterValue)) {
                            card.style.display = 'flex';
                            card.classList.add('animate-fadeIn');
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Info Filter Pills Interactivity
            const infoFilters = document.querySelectorAll('.info-filter-btn');
            const infoCards = document.querySelectorAll('.info-card-item');

            infoFilters.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Update active button classes
                    infoFilters.forEach(b => {
                        b.classList.remove('bg-butter-gold-500', 'text-white', 'shadow-sm', 'active');
                        b.classList.add('bg-white', 'border', 'border-warm-beige', 'text-brand-muted');
                    });
                    btn.classList.remove('bg-white', 'border', 'border-warm-beige', 'text-brand-muted');
                    btn.classList.add('bg-butter-gold-500', 'text-white', 'shadow-sm', 'active');

                    const filterValue = btn.getAttribute('data-filter');

                    infoCards.forEach(card => {
                        const cardCat = card.getAttribute('data-category') || '';
                        if (filterValue === 'all' || cardCat.includes(filterValue)) {
                            card.style.display = 'flex';
                            card.classList.add('animate-fadeIn');
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>