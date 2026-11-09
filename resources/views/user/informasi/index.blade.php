@extends('layouts.frontend')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sora', sans-serif;
        }

        .info-description {
            overflow-wrap: anywhere;
            word-break: break-word;
            min-width: 0;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Header & Search -->
        <div class="mb-8" data-reveal>

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">

                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-dark">
                        Info & Pengumuman
                    </h1>

                    <p class="text-sm text-brand-muted mt-2">
                        Temukan berita dan pengumuman terbaru seputar sekolah.
                    </p>
                </div>

                <!-- Search Bar -->
                <form action="{{ route('user.infoumum') }}" method="GET" class="flex items-center gap-2 w-full lg:w-auto">

                    <div class="relative flex-1 lg:w-72">

                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-brand-muted text-xl">
                            search
                        </span>

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari informasi..."
                            class="w-full pl-12 pr-4 py-3 rounded-xl border border-warm-beige bg-white text-sm focus:outline-none focus:ring-2 focus:ring-butter-gold-400 focus:border-butter-gold-400 transition">

                    </div>

                    @if (request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif

                    <button type="submit"
                        class="flex items-center justify-center px-5 py-3 rounded-xl bg-brand-dark text-white hover:bg-butter-gold-600 transition">
                        <span class="material-symbols-outlined text-lg">
                            search
                        </span>
                    </button>

                </form>

            </div>

        </div>

        <!-- Category Filters -->
        @php
            $categories = [
                'semua' => 'Semua',
                'berita' => 'Berita',
                'pengumuman' => 'Pengumuman',
            ];

            $activeCategory = strtolower(request('kategori', 'semua'));
        @endphp

        <div class="flex flex-wrap items-center gap-2 mb-8" data-reveal="fade">

            @foreach ($categories as $value => $label)

                <a href="{{ request()->fullUrlWithQuery(['kategori' => $value]) }}"
                    class="px-5 py-2.5 rounded-full text-xs sm:text-sm font-semibold transition-all
                    {{ $activeCategory === $value
                ? 'bg-butter-gold-500 text-white shadow-sm'
                : 'bg-white border border-warm-beige text-brand-muted hover:bg-warm-beige-light hover:text-brand-dark' }}">
                    {{ $label }}
                </a>

            @endforeach

        </div>

        <div class="space-y-4" data-reveal-group>
            @forelse ($infos as $item)
                @php
                    $cat = strtolower($item->kategori ?? 'berita');
                    $isBerita = str_contains($cat, 'berita');
                @endphp
                <article
                    class="flex flex-col md:flex-row bg-white rounded-xl shadow-soft hover:shadow-card-hover transition-all p-4 md:p-6 border border-warm-beige">
                    @if (!empty($item->gambar))
                        <div class="flex-shrink-0 w-full md:w-48 h-32 md:h-40 overflow-hidden rounded-lg mb-4 md:mb-0 md:mr-6">
                            <img src="{{ asset('image/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform" loading="lazy" />
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-3 mb-2">
                            <span
                                class="px-3 py-0.5 rounded-md text-[11px] font-bold uppercase tracking-wider {{ $isBerita ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $item->kategori ?? 'Info' }}
                            </span>
                            <span class="text-xs text-brand-muted flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d M Y') : (optional($item->created_at)->format('d M Y') ?? '-') }}
                            </span>
                        </div>
                        <h3 class="font-bold text-lg text-brand-dark hover:text-butter-gold-600 transition-colors line-clamp-1">
                            {{ $item->judul }}
                        </h3>
                        <p class="info-description text-sm text-brand-muted mt-2 line-clamp-2">
                            {{ Str::limit(strip_tags($item->isi), 150) }}
                        </p>
                            <a href="{{ route('user.informasi.show', $item->id_info) }}"
                            class="inline-flex items-center gap-1 mt-3 text-butter-gold-600 hover:underline">
                            Baca Selengkapnya
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </article>
            @empty
                <p class="text-center text-brand-muted">Tidak ada informasi yang tersedia.</p>
            @endforelse
        </div>
    </div>
@endsection