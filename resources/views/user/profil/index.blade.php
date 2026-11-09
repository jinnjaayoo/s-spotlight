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
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- HEADER --}}
        <div class="text-center mb-16" data-reveal>
            <span
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-warm-beige text-xs font-semibold text-brand-muted uppercase tracking-wide">
                <span class="w-2 h-2 rounded-full bg-butter-gold-500"></span>
                Tentang Platform
            </span>

            <h1 class="text-3xl sm:text-4xl font-extrabold text-brand-dark mt-6 mb-5">
                Tentang <span class="italic text-butter-gold-600">S'Spotlight</span>
            </h1>

            <p class="text-sm sm:text-base text-brand-muted max-w-2xl mx-auto leading-relaxed">
                Wadah apresiasi digital yang dirancang untuk mendokumentasikan,
                merayakan, dan memperkenalkan karya inovatif serta talenta vokasi
                siswa-siswi SMKN 2 Purwakarta ke panggung yang lebih luas.
            </p>
        </div>

        {{-- INSTITUSI --}}
        <div class="bg-white rounded-2xl border border-warm-beige p-6 sm:p-10 mb-16" data-reveal>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">

                <div>
                    <span class="text-xs font-bold text-butter-gold-600 uppercase tracking-wider">
                        Institusi Induk
                    </span>

                    <h2 class="text-xl sm:text-2xl font-bold text-brand-dark mt-3 mb-3">
                        SMKN 2 Purwakarta
                    </h2>

                    <p class="text-sm text-brand-muted leading-relaxed">
                        Sekolah Menengah Kejuruan Pusat Keunggulan yang berdedikasi
                        melahirkan pelajar tangguh, adaptif terhadap inovasi teknologi,
                        dan berdaya saing tinggi di dunia industri nasional maupun global.
                    </p>
                </div>

                <div class="md:text-right">
                    <a href="https://smkn2pwk.sch.id/" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-full bg-butter-gold-400 text-brand-dark text-sm font-semibold hover:bg-butter-gold-500 transition">
                        Kunjungi Website Resmi
                        <span class="material-symbols-outlined text-sm">
                            open_in_new
                        </span>
                    </a>
                </div>

            </div>
        </div>

        {{-- NILAI INTI --}}
        <div class="text-center mb-8" data-reveal>
            <span class="text-xs font-bold text-butter-gold-600 uppercase tracking-wider">
                Nilai Inti
            </span>

            <h2 class="text-2xl font-bold text-brand-dark mt-2">
                Prinsip Kami
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-16" data-reveal-group>

            @foreach ([
                    [
                        'icon' => 'workspace_premium',
                        'title' => 'Apresiasi',
                        'description' => 'Memberikan rekognisi dan penghargaan tulus atas setiap ide orisinal, dedikasi, serta ketekunan karya yang diciptakan siswa.'
                    ],
                    [
                        'icon' => 'lightbulb',
                        'title' => 'Inspirasi',
                        'description' => 'Menjadi pemicu keberanian berkarya bagi adik tingkat serta rekan sebaya agar terus bereksplorasi melampaui kurikulum standar.'
                    ],
                    [
                        'icon' => 'handshake',
                        'title' => 'Kolaborasi',
                        'description' => 'Menjembatani potensi talenta vokasi dengan mitra dunia usaha dan dunia industri untuk membuka peluang masa depan nyata.'
                    ]
                ] as $value)

                <div class="bg-warm-beige-light rounded-xl p-6 border border-warm-beige">
                    <div class="w-11 h-11 rounded-full bg-butter-gold-300 flex items-center justify-center mb-5">
                        <span class="material-symbols-outlined text-brand-dark">
                            {{ $value['icon'] }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-brand-dark mb-2">
                        {{ $value['title'] }}
                    </h3>

                    <p class="text-sm text-brand-muted leading-relaxed">
                        {{ $value['description'] }}
                    </p>
                </div>

            @endforeach

        </div>

        {{-- KONTAK RESMI SEKOLAH --}}
        <div class="bg-warm-beige rounded-2xl p-6 sm:p-8" data-reveal>

            <span class="text-xs font-bold text-butter-gold-600 uppercase tracking-wider">
                Kontak &amp; Informasi
            </span>

            <h2 class="text-2xl font-bold text-brand-dark mt-2">
                Kontak Resmi SMKN 2 Purwakarta
            </h2>

            <p class="text-sm text-brand-muted mt-2 mb-6 max-w-2xl leading-relaxed">
                Untuk pertanyaan resmi seputar sekolah, kemitraan industri, atau
                informasi akademik, silakan hubungi SMKN 2 Purwakarta melalui
                kanal resmi berikut.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" data-reveal-group>

                {{-- Alamat --}}
                <div class="bg-white rounded-xl p-5 flex items-start gap-4">
                    <span
                        class="w-10 h-10 rounded-full bg-butter-gold-100 text-butter-gold-800 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-xl">location_on</span>
                    </span>

                    <div class="min-w-0">
                        <h3 class="font-semibold text-brand-dark mb-1">
                            Alamat Sekolah
                        </h3>

                        <p class="text-sm text-brand-muted leading-relaxed">
                            Jl. Jend. A. Yani No. 98,<br>
                            Kelurahan Nagri Tengah,<br>
                            Kec. Purwakarta, Kab. Purwakarta,<br> 
                            Jawa Barat 41114
                        </p>
                    </div>
                </div>

                {{-- Website --}}
                <div class="bg-white rounded-xl p-5 flex items-start gap-4">
                    <span
                        class="w-10 h-10 rounded-full bg-butter-gold-100 text-butter-gold-800 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-xl">language</span>
                    </span>

                    <div class="min-w-0">
                        <h3 class="font-semibold text-brand-dark mb-1">
                            Website Resmi
                        </h3>

                        <a href="https://www.smkn2pwk.sch.id" target="_blank" rel="noopener noreferrer"
                            class="text-sm text-butter-gold-700 hover:text-butter-gold-900 hover:underline break-words">
                            www.smkn2pwk.sch.id
                        </a>

                        <p class="text-xs text-brand-muted mt-1.5 leading-relaxed">
                            Sumber informasi resmi sekolah, termasuk pengumuman
                            dan penerimaan peserta didik baru.
                        </p>
                    </div>
                </div>

                {{-- Telepon --}}
                <div class="bg-white rounded-xl p-5 flex items-start gap-4">
                    <span
                        class="w-10 h-10 rounded-full bg-butter-gold-100 text-butter-gold-800 flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-xl">call</span>
                    </span>

                    <div class="min-w-0">
                        <h3 class="font-semibold text-brand-dark mb-1">
                            Telepon
                        </h3>

                        <a href="tel:+62264200724"
                            class="text-sm text-butter-gold-700 hover:text-butter-gold-900 hover:underline">
                            (0264) 200724
                        </a>

                    </div>
                </div>

                {{-- Kanal yang belum terverifikasi --}}
                <div class="bg-white rounded-xl p-5 flex items-start gap-4">
                    <span
                        class="w-10 h-10 rounded-full bg-warm-beige text-brand-muted flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-xl">mail</span>
                    </span>

                    <div class="min-w-0">
                        <h3 class="font-semibold text-brand-dark mb-1">
                            Email &amp; Media Sosial
                        </h3>

                        <p class="text-sm text-brand-muted leading-relaxed">
                            <a href="mail to:smkn2.purwakarta@yahoo.com"
                                class="text-sm text-butter-gold-700 hover:text-butter-gold-900 hover:underline">
                                smkn2.purwakarta@yahoo.com
                            </a>
<br>
                            <a href="https://www.instagram.com/smekda.official/"
                                class="text-sm text-butter-gold-700 hover:text-butter-gold-900 hover:underline">
                                smekda.official on Instagram
                            </a>

                        </p>
                    </div>
                </div>

            </div>

            <p class="text-xs text-brand-muted mt-5 leading-relaxed">
                S'Spotlight adalah platform apresiasi karya siswa dan bukan kanal
                layanan resmi sekolah. Untuk urusan administrasi, silakan hubungi
                SMKN 2 Purwakarta secara langsung melalui kontak di atas.
            </p>

        </div>

    </div>
@endsection