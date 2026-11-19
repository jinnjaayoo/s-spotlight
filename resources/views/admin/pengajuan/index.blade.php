@extends('layouts.admin')

@section('title', "Pengajuan Karya Siswa - S'Spotlight")

@section('content')

    <!-- HEADER -->
    <header class="page-header">
        <div>
            <h1>Pengajuan Karya Siswa</h1>
        </div>
    </header>

    <!-- CONTENT SECTION -->
    <section class="data-section">

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert-danger" style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- FILTER TABS STATUS -->
        <div class="filter-tabs">
            <a href="{{ route('admin.pengajuan.index') }}"
               class="filter-tab {{ !request('status') ? 'active' : '' }}">
                Semua Pengajuan
                <span class="tab-count">{{ $counts['all'] }}</span>
            </a>

            <a href="{{ route('admin.pengajuan.index', ['status' => 'pending'] + request()->except('status', 'page')) }}"
               class="filter-tab {{ request('status') === 'pending' ? 'active' : '' }}">
                ⏳ Menunggu Peninjauan
                <span class="tab-count" style="{{ $counts['pending'] > 0 ? 'background: #ef4444; color: #fff;' : '' }}">
                    {{ $counts['pending'] }}
                </span>
            </a>

            <a href="{{ route('admin.pengajuan.index', ['status' => 'approved'] + request()->except('status', 'page')) }}"
               class="filter-tab {{ request('status') === 'approved' ? 'active' : '' }}">
                ✓ Disetujui
                <span class="tab-count">{{ $counts['approved'] }}</span>
            </a>

            <a href="{{ route('admin.pengajuan.index', ['status' => 'rejected'] + request()->except('status', 'page')) }}"
               class="filter-tab {{ request('status') === 'rejected' ? 'active' : '' }}">
                ✕ Ditolak
                <span class="tab-count">{{ $counts['rejected'] }}</span>
            </a>
        </div>

        <!-- SEARCH & FILTER TOOLBAR -->
        <form method="GET" action="{{ route('admin.pengajuan.index') }}" class="table-toolbar">
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <div class="search-box">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama siswa, kelas, judul karya...">
                <button type="submit" class="search-submit" aria-label="Cari">⌕</button>
            </div>

            <!-- Filter Kategori -->
            <select class="filter-select" name="kategori" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                <option value="Web" {{ request('kategori') == 'Web' ? 'selected' : '' }}>Web</option>
                <option value="Apk" {{ request('kategori') == 'Apk' ? 'selected' : '' }}>Apk</option>
                <option value="Desain" {{ request('kategori') == 'Desain' ? 'selected' : '' }}>Desain</option>
                <option value="Gambar" {{ request('kategori') == 'Gambar' ? 'selected' : '' }}>Gambar</option>
            </select>

            <!-- Filter Status Publikasi -->
            <select class="filter-select" name="status_publikasi" onchange="this.form.submit()">
                <option value="">Semua Publikasi</option>
                <option value="dipublikasikan" {{ request('status_publikasi') == 'dipublikasikan' ? 'selected' : '' }}>Dipublikasikan</option>
                <option value="belum_dipublikasi" {{ request('status_publikasi') == 'belum_dipublikasi' ? 'selected' : '' }}>Belum Publikasi</option>
            </select>
        </form>

        <!-- DATA TABLE -->
        <div class="table-wrapper">
            <table class="data-table adm-table-pengajuan">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th>Karya</th>
                        <th>Nama Siswa &amp; Kelas</th>
                        <th>Kategori</th>
                        <th>Tgl Pengajuan</th>
                        <th>Status Peninjauan</th>
                        <th>Publikasi</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pengajuans as $item)
                        <tr>
                            <td class="col-no">
                                {{ ($pengajuans->currentPage() - 1) * $pengajuans->perPage() + $loop->iteration }}
                            </td>

                            <td>
                                <div class="portfolio-cell">
                                    <div class="portfolio-thumbnail">
                                        @if ($item->gambar && file_exists(public_path('image/' . $item->gambar)))
                                            <img src="{{ asset('image/' . $item->gambar) }}" alt="{{ $item->judul_karya }}">
                                        @else
                                            🎨
                                        @endif
                                    </div>
                                    <div>
                                        <h4>{{ $item->judul_karya }}</h4>
                                        <p>{{ Str::limit(strip_tags($item->deskripsi), 70) }}</p>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div class="adm-student">
                                    <strong>{{ $item->nama_siswa }}</strong>
                                    <small>Kelas {{ $item->kelas }}</small>
                                </div>
                            </td>

                            <td>
                                <span class="badge {{ strtolower($item->kategori) }}">
                                    {{ $item->kategori }}
                                </span>
                            </td>

                            <td>
                                <div class="adm-date">
                                    {{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '-' }}
                                    <small>{{ $item->created_at ? $item->created_at->format('H:i') . ' WIB' : '' }}</small>
                                </div>
                            </td>

                            <td>
                                @if ($item->status === 'pending')
                                    <span class="status-badge pending">⏳ Menunggu</span>
                                @elseif ($item->status === 'approved')
                                    <span class="status-badge approved">✓ Disetujui</span>
                                @elseif ($item->status === 'rejected')
                                    <span class="status-badge rejected">✕ Ditolak</span>
                                @else
                                    <span class="status-badge">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>

                            <td>
                                @if ($item->status_publikasi === 'dipublikasikan')
                                    <span class="status-badge dipublikasikan">Dipublikasikan</span>
                                @else
                                    <span class="status-badge belum_dipublikasi">Belum Terbit</span>
                                @endif
                            </td>

                            <td class="col-aksi">
                                <div class="adm-action-group">
                                    <a href="{{ route('admin.pengajuan.show', $item->id_pengumpulan) }}"
                                       class="adm-btn adm-btn--dark adm-btn--sm"
                                       title="Buka Detail &amp; Tinjau">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Tinjau
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="adm-empty">
                                    <div class="adm-empty-emoji">📥</div>
                                    <h3>Tidak ada pengajuan karya</h3>
                                    <p>
                                        @if (request('search') || request('status') || request('kategori') || request('status_publikasi'))
                                            Tidak ditemukan pengajuan dengan kriteria pencarian/filter tersebut.
                                        @else
                                            Belum ada siswa yang mengajukan karya.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="table-footer">
            <div class="table-info">
                Menampilkan {{ $pengajuans->firstItem() ?? 0 }} - {{ $pengajuans->lastItem() ?? 0 }} dari {{ $pengajuans->total() }} pengajuan
            </div>

            {{ $pengajuans->links('admin.partials.pagination') }}
        </div>

    </section>

@endsection
