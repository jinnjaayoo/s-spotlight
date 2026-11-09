@extends('layouts.frontend')

@push('styles')
<style>
    .description-content {
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    .description-content img {
        max-width: 100%;
        height: auto;
    }
</style>
@endpush

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-10">

        <a href="{{ route('user.infoumum') }}" data-reveal="left"
           class="inline-flex items-center gap-2 text-sm text-brand-muted hover:text-butter-gold-600 mb-8">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Kembali ke Informasi
        </a>

        <article>

            <div class="flex flex-wrap items-center gap-3 mb-4" data-reveal>
                <span class="px-3 py-1 rounded-md text-xs font-bold uppercase bg-amber-100 text-amber-800">
                    {{ $info->kategori ?? 'Info' }}
                </span>

                <span class="text-sm text-brand-muted">
                    {{ $info->tanggal
                        ? \Carbon\Carbon::parse($info->tanggal)->format('d M Y')
                        : (optional($info->created_at)->format('d M Y') ?? '-') }}
                </span>
            </div>

            <h1 data-reveal class="text-2xl sm:text-3xl font-extrabold text-brand-dark leading-tight mb-6">
                {{ $info->judul }}
            </h1>

            @if ($info->gambar)
                <div class="mb-8 flex justify-center" data-reveal="scale">
                    <img
                        src="{{ asset('image/' . $info->gambar) }}"
                        alt="{{ $info->judul }}"
                        class="max-w-full max-h-[320px] object-contain rounded-lg"
                    >
                </div>
            @endif

            <div data-reveal class="description-content text-sm sm:text-base text-brand-muted leading-relaxed">
                {!! $info->isi !!}
            </div>

        </article>

    </div>
@endsection 