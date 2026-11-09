@extends('layouts.frontend')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Sora', sans-serif; }
    .gallery-item {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    background: #E7E2D6;
    aspect-ratio: 3 / 4;
}

.gallery-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-overlay {
    pointer-events: none;
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 24px;
    background: linear-gradient(
        to top,
        rgba(28, 27, 25, 0.85),
        rgba(28, 27, 25, 0.05) 70%
    );
    opacity: 0;
    transition: opacity 0.35s ease;
}

.gallery-item:hover .gallery-img {
    transform: scale(1.08);
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
}
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8" data-reveal>
    <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-dark">
                Galeri Foto
            </h1>

            <p class="text-sm text-brand-muted mt-2">
                Jelajahi berbagai karya kreatif siswa SMKN 2 Purwakarta.
            </p>
        </div>

    <form action="{{ route('user.galeri') }}" method="GET"
          class="flex items-center gap-2 w-full sm:w-auto">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari foto..."
            class="w-full sm:w-64 px-4 py-3 rounded-xl border border-warm-beige bg-white text-sm focus:outline-none focus:ring-2 focus:ring-butter-gold-400"
        >

        <button
            type="submit"
            class="px-4 py-3 rounded-xl bg-brand-dark text-white hover:bg-butter-gold-600 transition"
        >
            <span class="material-symbols-outlined text-sm">search</span>
        </button>

    </form>
</div>
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-5" data-reveal-group="scale">

    @forelse ($galeris as $item)

        <article class="gallery-item group">

            @if (!empty($item->gambar))

                <img
    src="{{ asset('image/'.$item->gambar) }}"
    alt="{{ $item->judul ?? 'Foto' }}"
    class="gallery-img cursor-zoom-in"
    loading="lazy"
    onclick="openLightbox(this.src, this.alt)"
>

            @else

                <div class="w-full h-full flex items-center justify-center bg-warm-beige">
                    <span class="material-symbols-outlined text-4xl text-butter-gold-500">
                        image
                    </span>
                </div>

            @endif

            <div class="gallery-overlay">

                <h3 class="text-xs sm:text-xl font-bold text-white">
                    {{ $item->judul ?? 'Tanpa Judul' }}
                </h3>

                <p class="text-[10px] sm:text-sm text-white/75 mt-1">
                    {{ $item->created_at ? $item->created_at->format('d M Y') : '' }}
                </p>

            </div>

        </article>

    @empty

        <p class="col-span-full text-center text-brand-muted">
            Tidak ada foto dalam galeri.
        </p>

    @endforelse

        </div>

    <div class="mt-8" data-reveal="fade">
        {{ $galeris->links() }}
    </div>
    
</div>

<!-- Lightbox -->
<div id="lightbox"
     class="hidden fixed inset-0 z-[100] bg-black/90 items-center justify-center p-4"
     onclick="closeLightbox()">

    <button
        type="button"
        onclick="closeLightbox()"
        class="absolute top-5 right-5 text-white text-3xl hover:text-butter-gold-400 transition"
        aria-label="Tutup foto"
    >
        &times;
    </button>

    <div class="max-w-5xl max-h-[90vh] flex flex-col items-center"
         onclick="event.stopPropagation()">

        <img
            id="lightbox-image"
            src=""
            alt=""
            class="max-w-full max-h-[75vh] object-contain rounded-xl"
        >

        <p id="lightbox-title"
           class="text-white text-sm sm:text-base text-center mt-4">
        </p>

    </div>
</div>

@push('scripts')
<script>
    function openLightbox(src, alt) {
        const lightbox = document.getElementById('lightbox');
        const image = document.getElementById('lightbox-image');
        const title = document.getElementById('lightbox-title');

        image.src = src;
        image.alt = alt;
        title.textContent = alt;

        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');

        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        const lightbox = document.getElementById('lightbox');

        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');

        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeLightbox();
        }
    });
</script>
@endpush

@endsection

