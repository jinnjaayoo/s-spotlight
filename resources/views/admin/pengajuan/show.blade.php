@extends('layouts.admin')

@section('title', "Detail Pengajuan: {$pengajuan->judul_karya} - S'Spotlight")

@section('content')

    <!-- HEADER -->
    <header class="page-header" style="align-items: center;">
        <div>
            <div style="margin-bottom: 8px;">
                <a href="{{ route('admin.pengajuan.index') }}"
                   style="display: inline-flex; align-items: center; gap: 6px; font-size: 13.5px; font-weight: 600; color: var(--gray, #6b7280); text-decoration: none;">
                    &larr; Kembali ke Daftar Pengajuan
                </a>
            </div>
            <h1>Detail Pengajuan Karya</h1>
            <p>Pengajuan oleh <strong>{{ $pengajuan->nama_siswa }}</strong> (Kelas {{ $pengajuan->kelas }})</p>
        </div>

        <div class="header-actions">
            <a href="{{ route('admin.pengajuan.download', $pengajuan->id_pengumpulan) }}"
               class="adm-btn adm-btn--blue">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                </svg>
                Unduh Gambar Asli
            </a>
        </div>
    </header>

    <section class="data-section" style="padding: 24px;">

        @if (session('success'))
            <div class="alert-success" style="margin-bottom: 20px;">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert-danger" style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 24px; align-items: start;">

            <!-- KOLOM KIRI: GAMBAR & STATUS PENINJAUAN -->
            <div style="display: flex; flex-direction: column; gap: 20px;">

                <!-- KARTU PREVIEW GAMBAR -->
                <div style="background: #fff; border: 1px solid var(--border, #e5e7eb); border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 14px; color: var(--dark, #17181c);">
                        Preview Gambar Karya
                    </h3>

                    <div style="border-radius: 10px; overflow: hidden; background: #f8fafc; border: 1px solid #e2e8f0; text-align: center; position: relative;">
                        @if ($pengajuan->gambar && file_exists(public_path('image/' . $pengajuan->gambar)))
                            <img src="{{ asset('image/' . $pengajuan->gambar) }}"
                                 alt="{{ $pengajuan->judul_karya }}"
                                 style="width: 100%; max-height: 420px; object-fit: contain; display: block; background: #f1f5f9;">
                        @else
                            <div style="padding: 60px 20px; color: #64748b;">
                                <div style="font-size: 40px; margin-bottom: 8px;">🖼️</div>
                                <p>Gambar tidak ditemukan di direktori penyimpanan.</p>
                            </div>
                        @endif
                    </div>

                    <div style="margin-top: 14px; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                        <span style="font-size: 12px; color: #64748b;">
                            File: <code>{{ $pengajuan->gambar ?? '-' }}</code>
                        </span>

                        <a href="{{ route('admin.pengajuan.download', $pengajuan->id_pengumpulan) }}"
                           style="font-size: 12.5px; font-weight: 600; color: #2563eb; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                            ↆ Unduh Berkas
                        </a>
                    </div>
                </div>

                <!-- KARTU KONTROL STATUS PENINJAUAN -->
                <div style="background: #fff; border: 1px solid var(--border, #e5e7eb); border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 12px; color: var(--dark, #17181c);">
                        Status Peninjauan &amp; Publikasi
                    </h3>

                    <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px;">
                        <div>
                            <span style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;">Status Peninjauan:</span>
                            @if ($pengajuan->status === 'pending')
                                <span class="status-badge pending" style="font-size: 13px; padding: 6px 12px;">Menunggu Peninjauan</span>
                            @elseif ($pengajuan->status === 'approved')
                                <span class="status-badge approved" style="font-size: 13px; padding: 6px 12px;">✓ Disetujui</span>
                            @elseif ($pengajuan->status === 'rejected')
                                <span class="status-badge rejected" style="font-size: 13px; padding: 6px 12px;">✕ Ditolak</span>
                            @endif
                        </div>

                        <div>
                            <span style="font-size: 12px; color: #64748b; display: block; margin-bottom: 4px;">Status Publikasi:</span>
                            @if ($pengajuan->status_publikasi === 'dipublikasikan')
                                <span class="status-badge dipublikasikan" style="font-size: 13px; padding: 6px 12px;">
                                    Sudah Dipublikasikan
                                </span>
                            @else
                                <span class="status-badge belum_dipublikasi" style="font-size: 13px; padding: 6px 12px;">
                                    Belum Dipublikasikan
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($pengajuan->status_publikasi === 'dipublikasikan' && $pengajuan->portofolio)
                        <div style="padding: 12px; background: #e0e7ff; border-radius: 8px; font-size: 12.5px; color: #3730a3; margin-bottom: 16px;">
                            ℹ️ Karya ini telah terbit di Portofolio:
                            <a href="{{ route('admin.porto.edit', $pengajuan->id_portofolio) }}" style="font-weight: 700; text-decoration: underline; color: #1e1b4b;">
                                {{ $pengajuan->portofolio->nama_portofolio }} &rarr;
                            </a>
                        </div>
                    @endif

                    <!-- FORM UBAH STATUS PENINJAUAN -->
                    <form action="{{ route('admin.pengajuan.status', $pengajuan->id_pengumpulan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label style="font-size: 13px; font-weight: 600; margin-bottom: 8px; display: block;">
                            Ubah Status Peninjauan:
                        </label>

                        <div style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px;">
                            <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1px solid var(--border, #e5e7eb); border-radius: 8px; cursor: pointer; background: {{ $pengajuan->status === 'pending' ? '#fffbeb' : '#fff' }};">
                                <input type="radio" name="status" value="pending" {{ $pengajuan->status === 'pending' ? 'checked' : '' }}>
                                <div>
                                    <strong style="color: #92400e; font-size: 13.5px;">Menunggu Peninjauan (Pending)</strong>
                                    <p style="margin: 0; font-size: 12px; color: #78350f;">Karya masih dalam proses antrean evaluasi admin.</p>
                                </div>
                            </label>

                            <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1px solid var(--border, #e5e7eb); border-radius: 8px; cursor: pointer; background: {{ $pengajuan->status === 'approved' ? '#f0fdf4' : '#fff' }};">
                                <input type="radio" name="status" value="approved" {{ $pengajuan->status === 'approved' ? 'checked' : '' }}>
                                <div>
                                    <strong style="color: #166534; font-size: 13.5px;">Disetujui (Approved)</strong>
                                    <p style="margin: 0; font-size: 12px; color: #14532d;">Karya memenuhi syarat dan dapat dilanjutkan ke publikasi portofolio.</p>
                                </div>
                            </label>

                            <label style="display: flex; align-items: center; gap: 10px; padding: 10px 14px; border: 1px solid var(--border, #e5e7eb); border-radius: 8px; cursor: pointer; background: {{ $pengajuan->status === 'rejected' ? '#fef2f2' : '#fff' }};">
                                <input type="radio" name="status" value="rejected" {{ $pengajuan->status === 'rejected' ? 'checked' : '' }}>
                                <div>
                                    <strong style="color: #991b1b; font-size: 13.5px;">Ditolak (Rejected)</strong>
                                    <p style="margin: 0; font-size: 12px; color: #7f1d1d;">Karya belum memenuhi standar / tidak layak terbit.</p>
                                </div>
                            </label>
                        </div>

                        <button type="submit" class="adm-btn adm-btn--primary adm-btn--block" style="height: 44px; color: #17181c;">
                            Simpan Perubahan Status
                        </button>
                    </form>

                </div>

                <!-- KARTU INTEGRASI PUBLIKASI PORTOFOLIO -->
                <div style="background: #fff; border: 1px solid var(--border, #e5e7eb); border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <h3 style="font-size: 15px; font-weight: 700; margin-bottom: 12px; color: var(--dark, #17181c);">
                        Publikasi ke Portofolio
                    </h3>

                    @if ($pengajuan->status === 'approved' && $pengajuan->status_publikasi !== 'dipublikasikan')
                        <!-- KARYA DISETUJUI & BELUM TERBIT: TAMPILKAN FORM TERBITKAN -->
                        <div style="background: #f0fdf4; border: 1.5px dashed #86efac; border-radius: 10px; padding: 16px; margin-bottom: 12px;">
                            <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 12px;">
                                <span style="font-size: 22px; line-height: 1;">🚀</span>
                                <div>
                                    <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #166534;">
                                        Karya Siap Dipublikasikan
                                    </h4>
                                    <p style="margin: 2px 0 0 0; font-size: 12px; color: #15803d; line-height: 1.5;">
                                        Pengajuan ini telah disetujui. Tekan tombol di bawah untuk menyalin karya ke Portofolio publik. Berkas asli pengajuan tetap aman tersimpan.
                                    </p>
                                </div>
                            </div>

                            <form action="{{ route('admin.pengajuan.publish', $pengajuan->id_pengumpulan) }}" method="POST">
                                @csrf

                                <div style="margin-bottom: 10px;">
                                    <label style="font-size: 12px; font-weight: 600; color: #166534; display: block; margin-bottom: 3px;">
                                        Teknologi / Tools yang Digunakan (Opsional):
                                    </label>
                                    <input type="text"
                                           name="teknologi"
                                           placeholder="Contoh: Laravel, Tailwind CSS, Figma, dsb."
                                           style="width: 100%; padding: 8px 12px; border: 1px solid #bbf7d0; border-radius: 6px; font-size: 13px; background: #fff;">
                                </div>

                                <div style="margin-bottom: 14px;">
                                    <label style="font-size: 12px; font-weight: 600; color: #166534; display: block; margin-bottom: 3px;">
                                        Tautan Portofolio / Live Demo (Opsional):
                                    </label>
                                    <input type="url"
                                           name="link_portofolio"
                                           placeholder="https://..."
                                           style="width: 100%; padding: 8px 12px; border: 1px solid #bbf7d0; border-radius: 6px; font-size: 13px; background: #fff;">
                                </div>

                                <button type="submit" class="adm-btn adm-btn--green adm-btn--block" style="height: 44px;">
                                    <span aria-hidden="true">🚀</span> Terbitkan ke Portofolio
                                </button>
                            </form>
                        </div>
                    @elseif ($pengajuan->status_publikasi === 'dipublikasikan')
                        <!-- SUDAH DIPUBLIKASIKAN -->
                        <div style="background: #eef2ff; border: 1.5px solid #c7d2fe; border-radius: 10px; padding: 16px;">
                            <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 12px;">
                                <span style="font-size: 22px; line-height: 1;">✓</span>
                                <div>
                                    <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #3730a3;">
                                        Karya Telah Diterbitkan
                                    </h4>
                                    <p style="margin: 2px 0 0 0; font-size: 12px; color: #4338ca; line-height: 1.5;">
                                        Karya ini sudah tampil di halaman Portofolio publik website. Sistem mencegah duplikasi agar karya tidak diterbitkan ganda.
                                    </p>
                                </div>
                            </div>

                            <div class="adm-btn-row">
                                @if ($pengajuan->id_portofolio)
                                    <a href="{{ route('admin.porto.edit', $pengajuan->id_portofolio) }}"
                                       class="adm-btn adm-btn--indigo">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Kelola di Portofolio
                                    </a>
                                @endif

                                <form action="{{ route('admin.pengajuan.unpublish', $pengajuan->id_pengumpulan) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menarik karya ini dari Portofolio publik? Data pengajuan siswa tetap tersimpan aman.');">
                                    @csrf
                                    <button type="submit" class="adm-btn adm-btn--danger-ghost">
                                        Tarik Publikasi
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- STATUS BUKAN APPROVED (PENDING ATAU REJECTED) -->
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; font-size: 12.5px; color: #64748b; line-height: 1.5;">
                            @if ($pengajuan->status === 'pending')
                                🔒 <strong>Belum Memenuhi Syarat Publikasi</strong><br>
                                Karya masih berstatus <em>Menunggu Peninjauan</em>. Ubah status peninjauan menjadi <strong>Disetujui</strong> terlebih dahulu agar dapat diterbitkan ke Portofolio.
                            @elseif ($pengajuan->status === 'rejected')
                                ✕ <strong>Karya Ditolak</strong><br>
                                Pengajuan ini berstatus <em>Ditolak</em> sehingga tidak dapat dipublikasikan. Ubah status menjadi <strong>Disetujui</strong> jika karya memenuhi kriteria revisi.
                            @endif
                        </div>
                    @endif
                </div>

            </div>

            <!-- KOLOM KANAN: DETAIL FORMULIR SISWA -->
            <div style="background: #fff; border: 1px solid var(--border, #e5e7eb); border-radius: 12px; padding: 24px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">

                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 20px; color: var(--dark, #17181c); padding-bottom: 12px; border-bottom: 1px solid var(--border, #e5e7eb);">
                    Informasi Formulir Pengajuan Siswa
                </h3>

                <div style="display: flex; flex-direction: column; gap: 18px;">

                    <div>
                        <span style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray, #6b7280); font-weight: 600; display: block; margin-bottom: 4px;">
                            Judul Karya
                        </span>
                        <h2 style="font-size: 20px; font-weight: 800; color: var(--dark, #17181c); margin: 0;">
                            {{ $pengajuan->judul_karya }}
                        </h2>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; padding: 14px; background: var(--surface-muted, #f8fafc); border-radius: 8px; border: 1px solid #edf2f7;">
                        <div>
                            <span style="font-size: 12px; color: var(--gray, #6b7280); font-weight: 600; display: block;">
                                Nama Siswa (Pekarya)
                            </span>
                            <strong style="font-size: 14.5px; color: var(--dark, #17181c);">
                                {{ $pengajuan->nama_siswa }}
                            </strong>
                        </div>

                        <div>
                            <span style="font-size: 12px; color: var(--gray, #6b7280); font-weight: 600; display: block;">
                                Kelas
                            </span>
                            <strong style="font-size: 14.5px; color: var(--dark, #17181c);">
                                {{ $pengajuan->kelas }}
                            </strong>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div>
                            <span style="font-size: 12px; color: var(--gray, #6b7280); font-weight: 600; display: block; margin-bottom: 4px;">
                                Kategori Karya
                            </span>
                            <span class="badge {{ strtolower($pengajuan->kategori) }}" style="font-size: 13px; padding: 4px 12px;">
                                {{ $pengajuan->kategori }}
                            </span>
                        </div>

                        <div>
                            <span style="font-size: 12px; color: var(--gray, #6b7280); font-weight: 600; display: block; margin-bottom: 4px;">
                                Tanggal &amp; Waktu Pengajuan
                            </span>
                            <div style="font-size: 13.5px; font-weight: 600; color: var(--dark, #17181c);">
                                {{ $pengajuan->created_at ? $pengajuan->created_at->translatedFormat('l, d F Y') : '-' }}
                            </div>
                            <div style="font-size: 12px; color: var(--gray, #6b7280);">
                                Pukul {{ $pengajuan->created_at ? $pengajuan->created_at->format('H:i') : '' }} WIB
                                ({{ $pengajuan->created_at ? $pengajuan->created_at->diffForHumans() : '' }})
                            </div>
                        </div>
                    </div>

                    <div>
                        <span style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: var(--gray, #6b7280); font-weight: 600; display: block; margin-bottom: 6px;">
                            Deskripsi Karya Siswa
                        </span>
                        <div style="padding: 16px; background: #fafafa; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 14px; line-height: 1.7; color: #374151; white-space: pre-wrap; word-break: break-word;">{{ $pengajuan->deskripsi }}</div>
                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
