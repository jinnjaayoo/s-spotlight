@extends('layouts.frontend')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Sora', sans-serif;
        }

        /* Ditulis sebagai CSS biasa: @apply tidak tersedia pada Tailwind CDN. */
        .like-btn {
            display: inline-flex;
            align-items: center;
            gap: .25rem;
            color: #D9941E;
            cursor: pointer;
        }

        .like-btn:hover {
            color: #945B13;
        }

        .description-content {
            overflow-wrap: anywhere;
            word-break: break-word;
            max-width: 100%;
        }

        .description-content img {
            max-width: 100%;
            height: auto;
        }

        .description-content table {
            display: block;
            max-width: 100%;
            overflow-x: auto;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column: Image & Details -->
            <div class="space-y-6" data-reveal="left">
                @if (!empty($portofolio->gambar))
                    <img src="{{ asset('image/' . $portofolio->gambar) }}" alt="{{ $portofolio->nama_portofolio }}"
                        class="w-full max-h-[600px] rounded-xl object-contain bg-warm-beige" />
                @else
                    <div class="w-full h-64 bg-warm-beige flex items-center justify-center rounded-xl">
                        <span class="material-symbols-outlined text-6xl text-butter-gold-500">image</span>
                    </div>
                @endif
                <h1 class="text-xl sm:text-3xl font-extrabold text-brand-dark break-words">{{ $portofolio->nama_portofolio }}</h1>
                <div class="flex items-center gap-2 text-brand-muted">
                    <span class="material-symbols-outlined text-sm">person</span>
                    <span>{{ $portofolio->nama_siswa ?? 'Anon' }}</span>
                </div>
               <div class="description-content text-sm sm:text-base text-brand-muted leading-relaxed">
    {!! $portofolio->deskripsi ?? 'Deskripsi tidak tersedia.' !!}
</div>
                <div class="flex items-center gap-4">

                    <form action="{{ route('user.portofolio.love', $portofolio->id_portofolio) }}" method="POST">
                        @csrf

                        <button type="submit"
                            class="flex items-center gap-1 text-butter-gold-600 hover:text-butter-gold-800 transition-colors duration-300">

                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">
                                favorite
                            </span>

                            <span>{{ $portofolio->jumlah_love ?? 0 }}</span>
                        </button>
                    </form>

                    <span class="text-sm text-brand-muted">
                        Terakhir diperbarui: {{ optional($portofolio->updated_at)->format('d M Y') ?? '-' }}
                    </span>

                </div>
            </div>
            <!-- Right Column: Meta Info & Related -->
            <div class="space-y-6" data-reveal="right">
                <div class="p-5 bg-white rounded-xl shadow-soft border border-warm-beige">
                    <h2 class="text-xl font-bold text-brand-dark mb-3">Detail Karya</h2>
                    <ul class="space-y-2 text-sm text-brand-muted">
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">category</span>
                            Kategori: <span
                                class="font-medium text-brand-dark ml-1">{{ $portofolio->kategori ?? '-' }}</span></li>
                        <li class="flex items-center gap-2"><span
                                class="material-symbols-outlined text-sm">calendar_today</span> Tanggal: <span
                                class="font-medium text-brand-dark ml-1">{{ optional($portofolio->created_at)->format('d M Y') ?? '-' }}</span>
                        </li>
                        <li class="flex items-center gap-2"><span class="material-symbols-outlined text-sm">code</span>
                            Teknologi: <span
                                class="font-medium text-brand-dark ml-1">{{ $portofolio->teknologi ?? 'Tidak disebutkan' }}</span>
                        </li>
                    </ul>
                </div>
                 @if ($portofolio->link_portofolio)
                    <a
                        href="{{ $portofolio->link_portofolio }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl bg-brand-dark text-white font-semibold hover:bg-butter-gold-600 transition"
                    >
                        <span class="material-symbols-outlined text-sm">
                            open_in_new
                        </span>
                        Lihat Karya
                    </a>
                @endif

                <div class="p-5 bg-white rounded-xl shadow-soft border border-warm-beige">
                    <h2 class="text-xl font-bold text-brand-dark mb-4">
                        Karya Terkait
                    </h2>

                    @forelse ($karyaTerkait as $karya)
                        <a href="{{ route('user.detailporto', $karya->id_portofolio) }}"
                            class="flex items-center gap-3 mb-4 group">

                            @if ($karya->gambar)
                                <img src="{{ asset('image/' . $karya->gambar) }}" alt="{{ $karya->nama_portofolio }}"
                                    class="w-20 h-20 rounded-lg object-cover">
                            @else
                                <div class="w-20 h-20 rounded-lg bg-warm-beige flex items-center justify-center">
                                    <span class="material-symbols-outlined text-butter-gold-500">
                                        image
                                    </span>
                                </div>
                            @endif

                            <div>
                                <h3 class="font-semibold text-brand-dark group-hover:text-butter-gold-600 transition-colors">
                                    {{ $karya->nama_portofolio }}
                                </h3>

                                <p class="text-sm text-brand-muted">
                                    {{ $karya->kategori }}
                                </p>
                            </div>

                        </a>
                    @empty
                        <p class="text-sm text-brand-muted">
                            Belum ada karya terkait.
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const likeBtn = document.getElementById('like-button');
            const likeIcon = document.getElementById('like-icon');
            const likeCount = document.getElementById('like-count');
        });
    </script>
@endpush