@extends('layouts.frontend')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-xl w-full text-center" data-reveal>

            <!-- Card Sukses -->
            <div class="bg-white border border-warm-beige rounded-3xl shadow-soft p-8 sm:p-10">

                <!-- Icon Sukses -->
                <div class="mx-auto w-20 h-20 rounded-full bg-butter-gold-100 border-2 border-butter-gold-300 flex items-center justify-center mb-6 shadow-sm">
                    <span class="material-symbols-outlined text-4xl text-butter-gold-600 fill">check_circle</span>
                </div>

                <!-- Badge Keterangan -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-green-50 border border-green-200 text-green-700 text-xs font-bold tracking-wider uppercase mb-3">
                    <span class="material-symbols-outlined text-base text-green-600">verified</span>
                    Pengajuan Diterima
                </div>

                <!-- Judul Utama -->
                <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-dark mb-3">
                    Karya berhasil dikirim!
                </h1>

                <!-- Ringkasan Info Karya (jika ada session) -->
                @if (session('submitted_karya'))
                    <div class="my-5 p-4 rounded-2xl bg-off-white border border-warm-beige text-left text-sm">
                        <p class="text-xs text-brand-muted uppercase tracking-wider font-semibold mb-1">Judul Karya:</p>
                        <p class="font-bold text-brand-dark text-base">{{ session('submitted_karya.judul') }}</p>
                        <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-brand-muted">
                            <span><strong class="text-brand-dark">Pekarya:</strong> {{ session('submitted_karya.nama') }}</span>
                            <span><strong class="text-brand-dark">Kelas:</strong> {{ session('submitted_karya.kelas') }}</span>
                            <span><strong class="text-brand-dark">Kategori:</strong> {{ session('submitted_karya.kategori') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Penjelasan Proses Peninjauan & Estimasi 24 Jam -->
                <div class="rounded-2xl border border-warm-beige bg-warm-beige-light/50 p-5 text-left mb-6 space-y-3">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-butter-gold-600 text-xl mt-0.5">schedule</span>
                        <div>
                            <h2 class="text-sm font-bold text-brand-dark">Proses Peninjauan</h2>
                            <p class="text-xs sm:text-sm text-brand-muted mt-0.5 leading-relaxed">
                                Karyamu akan melalui proses peninjauan oleh admin untuk memastikan kelengkapan dan kesesuaian konten sebelum dipublikasikan.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 pt-2 border-t border-warm-beige/70">
                        <span class="material-symbols-outlined text-butter-gold-600 text-xl mt-0.5">hourglass_top</span>
                        <div>
                            <h2 class="text-sm font-bold text-brand-dark">Estimasi Waktu Peninjauan</h2>
                            <p class="text-xs sm:text-sm text-brand-muted mt-0.5 leading-relaxed">
                                Estimasi waktu peninjauan <strong class="text-brand-dark font-semibold">maksimal 24 jam</strong> pada hari kerja. Setelah disetujui oleh admin, karyamu akan diterbitkan di galeri Portofolio.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Tombol Navigasi -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('user.beranda') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-2xl bg-butter-gold-500 text-white font-bold text-sm hover:bg-butter-gold-600 hover:shadow-lg transition-all">
                        <span class="material-symbols-outlined text-xl">home</span>
                        Kembali ke Beranda
                    </a>

                    <a href="{{ route('user.pengajuan') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-white border-2 border-warm-beige text-brand-dark font-semibold text-sm hover:bg-warm-beige-light transition-all">
                        <span class="material-symbols-outlined text-xl text-butter-gold-600">add_circle</span>
                        Ajukan Karya Lain
                    </a>
                </div>

            </div>

        </div>
    </div>
@endsection
 