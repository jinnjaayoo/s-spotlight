@extends('layouts.frontend')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sora', sans-serif;
        }
    </style>
@endpush


@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Header -->
        <div class="mb-8" data-reveal>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-dark">
                Portofolio & Karya
            </h1>

            <p class="text-sm text-brand-muted mt-2">
                Jelajahi berbagai karya kreatif siswa SMKN 2 Purwakarta.
            </p>
        </div>

        <!-- Search & Filters -->
        <div class="mb-10 space-y-5" data-reveal="fade">

            <!-- Search Bar -->
            <form method="GET"
                  action="{{ route('user.portofolio') }}"
                  class="flex items-center gap-2 w-full sm:max-w-xl">

                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-brand-muted text-xl">
                        search
                    </span>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari karya atau nama siswa..."
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-warm-beige bg-white text-sm text-brand-dark focus:outline-none focus:ring-2 focus:ring-butter-gold-400 focus:border-butter-gold-400 transition"
                    >
                </div>

                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                <button
                    type="submit"
                    class="flex items-center justify-center px-5 py-3 rounded-xl bg-brand-dark text-white hover:bg-butter-gold-600 transition"
                >
                    <span class="material-symbols-outlined text-lg">
                        search
                    </span>
                </button>

            </form>

            <!-- Category Filters -->
            <div class="flex flex-wrap items-center gap-2">

                @php
                    $categories = ['Semua', 'Web', 'Apk', 'Desain', 'Gambar'];
                    $active = request('category', 'Semua');
                @endphp

                @foreach ($categories as $cat)
                    <a
                        href="{{ request()->fullUrlWithQuery(['category' => $cat]) }}"
                        class="px-4 py-2 rounded-full text-xs sm:text-sm font-medium transition
                        {{ $active == $cat
                            ? 'bg-butter-gold-500 text-white shadow-sm'
                            : 'bg-white border border-warm-beige text-brand-muted hover:bg-warm-beige-light hover:text-brand-dark' }}"
                    >
                        {{ $cat }}
                    </a>
                @endforeach

            </div>

        </div>

        <!-- Portfolio Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-reveal-group>

            @forelse ($portofolios as $item)

                <article class="relative bg-white rounded-xl shadow-soft hover:shadow-card-hover transition flex flex-col group">

                    <div class="relative w-full h-[220px] overflow-hidden rounded-t-xl bg-warm-beige">

                        @if (!empty($item->gambar))

                            <img
                                src="{{ asset('image/' . $item->gambar) }}"
                                alt="{{ $item->nama_portofolio }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                loading="lazy"
                            >

                        @else

                            <div class="w-full h-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-4xl text-butter-gold-500">
                                    image
                                </span>
                            </div>

                        @endif

                        <span class="absolute top-2 left-2 px-3 py-1 rounded-full text-xs font-semibold uppercase bg-butter-gold-100 text-butter-gold-800">
                            {{ $item->kategori ?? 'Karya' }}
                        </span>

                    </div>

                    <div class="p-4 flex-1 flex flex-col justify-between">

                        <h3 class="font-bold text-lg text-brand-dark group-hover:text-butter-gold-600 transition-colors line-clamp-2">
                            {{ $item->nama_portofolio }}
                        </h3>

                        <div class="flex items-center justify-between text-sm text-brand-muted mt-2">

                            <span class="flex items-center gap-1 min-w-0">
                                <span class="material-symbols-outlined text-sm">
                                    person
                                </span>

                                <span class="truncate">
                                    {{ $item->nama_siswa ?? 'Anon' }}
                                </span>
                            </span>

                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">
                                    favorite
                                </span>

                                {{ $item->jumlah_love ?? 0 }}
                            </span>

                        </div>

                    </div>

                    <a
                        href="{{ route('user.detailporto', $item->id_portofolio) }}"
                        class="absolute inset-0"
                        aria-label="Lihat detail {{ $item->nama_portofolio }}"
                    ></a>

                </article>

            @empty

                <p class="col-span-full text-center text-brand-muted">
                    Tidak ada portofolio yang cocok.
                </p>

            @endforelse

        </div>

    </div>
@endsection