@extends('layouts.admin')

@section('title', "Data Pekarya - S'Spotlight")

@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Data Pekarya</h1>
        <p class="page-subtitle">Rekap seluruh siswa yang pernah mengajukan karya</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('admin.pekarya.export') }}" class="adm-btn adm-btn--primary">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
            </svg>
            Unduh Laporan Excel
        </a>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div class="stats-grid adm-stats">
    <div class="stat-card">
        <div class="stat-icon stat-icon--indigo">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        </div>
        <div class="stat-info">
            <p>Total Pengajuan</p>
            <h2>{{ $totalPengajuan }}</h2>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon--green">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 2a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div class="stat-info">
            <p>Pekarya Unik</p>
            <h2>{{ $totalPekaryaUnik }}</h2>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon stat-icon--amber">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="stat-info">
            <p>Karya Dipublikasikan</p>
            <h2>{{ $totalDipublikasikan }}</h2>
        </div>
    </div>
</div>

{{-- FILTER & PENCARIAN --}}
<div class="table-toolbar">
    <form method="GET" action="{{ route('admin.pekarya.index') }}" class="adm-toolbar">

        <div class="search-box">
            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
            </svg>
            <input type="text" name="search" placeholder="Cari nama, kelas, atau judul..."
                   value="{{ request('search') }}" aria-label="Cari pekarya">
        </div>

        <select name="kategori" class="filter-select" aria-label="Filter kategori">
            <option value="">Semua Kategori</option>
            @foreach(['Web', 'Apk', 'Desain', 'Gambar'] as $kat)
                <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
            @endforeach
        </select>

        <select name="status" class="filter-select" aria-label="Filter status peninjauan">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Peninjauan</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>

        <select name="status_publikasi" class="filter-select" aria-label="Filter status publikasi">
            <option value="">Semua Publikasi</option>
            <option value="belum_dipublikasi" {{ request('status_publikasi') == 'belum_dipublikasi' ? 'selected' : '' }}>Belum Dipublikasi</option>
            <option value="dipublikasikan" {{ request('status_publikasi') == 'dipublikasikan' ? 'selected' : '' }}>Dipublikasikan</option>
        </select>

        <div class="adm-toolbar-actions">
            {{-- Tombol urut tanggal --}}
            <a href="{{ request()->fullUrlWithQuery(['sort' => $sortDirection === 'asc' ? 'desc' : 'asc']) }}"
               class="adm-btn adm-btn--ghost"
               title="Urut berdasarkan tanggal pengajuan">
                @if($sortDirection === 'desc')
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h13M3 8h9M3 12h5m10 4l-4 4-4-4m4-10v14"/>
                    </svg>
                    Terbaru
                @else
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4h13M3 8h9M3 12h5m10-4l-4-4-4 4m4 10V6"/>
                    </svg>
                    Terlama
                @endif
            </a>

            <button type="submit" class="adm-btn adm-btn--dark">Cari</button>

            @if(request()->hasAny(['search','kategori','status','status_publikasi','sort']))
                <a href="{{ route('admin.pekarya.index') }}" class="adm-btn adm-btn--ghost">Reset</a>
            @endif
        </div>

    </form>
</div>

{{-- TABEL DATA PEKARYA --}}
<div class="table-wrapper">
    <table class="data-table adm-table-pekarya">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th>Nama Siswa &amp; Kelas</th>
                <th>Judul Karya</th>
                <th>Kategori</th>
                <th>Tanggal Pengajuan</th>
                <th>Status Peninjauan</th>
                <th>Status Publikasi</th>
                <th class="col-aksi">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pekaryas as $index => $item)
            <tr>
                <td class="col-no">{{ $pekaryas->firstItem() + $index }}</td>
                <td>
                    <span class="cell-name">{{ $item->nama_siswa }}</span>
                    <span class="cell-class">Kelas {{ $item->kelas }}</span>
                </td>
                <td>
                    <span class="cell-title" title="{{ $item->judul_karya }}">
                        {{ $item->judul_karya }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ strtolower($item->kategori) }}">{{ $item->kategori }}</span>
                </td>
                <td>
                    <div class="adm-date">
                        {{ $item->created_at->format('d M Y') }}
                        <small>{{ $item->created_at->format('H:i') }} WIB</small>
                    </div>
                </td>
                <td>
                    @if($item->status === 'pending')
                        <span class="status-badge pending">Menunggu</span>
                    @elseif($item->status === 'approved')
                        <span class="status-badge approved">Disetujui</span>
                    @elseif($item->status === 'rejected')
                        <span class="status-badge rejected">Ditolak</span>
                    @else
                        <span class="status-badge">{{ $item->status }}</span>
                    @endif
                </td>
                <td>
                    @if($item->status_publikasi === 'dipublikasikan')
                        <span class="status-badge dipublikasikan">Dipublikasikan</span>
                    @else
                        <span class="status-badge belum_dipublikasi">Belum</span>
                    @endif
                </td>
                <td class="col-aksi">
                    <a href="{{ route('admin.pengajuan.show', $item->id_pengumpulan) }}"
                       class="adm-icon-btn" title="Lihat Detail" aria-label="Lihat detail {{ $item->judul_karya }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    @if(request()->hasAny(['search','kategori','status','status_publikasi']))
                        <div class="adm-empty">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                                <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" d="M21 21l-4.35-4.35"/>
                            </svg>
                            <h3>Data tidak ditemukan</h3>
                            <p>Tidak ada data yang cocok dengan pencarian atau filter.</p>
                            <a href="{{ route('admin.pekarya.index') }}">Reset filter</a>
                        </div>
                    @else
                        <div class="adm-empty">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-5.13a4 4 0 11-8 0 4 4 0 018 0zm6 2a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <h3>Belum ada data pekarya</h3>
                            <p>Belum ada siswa yang mengajukan karya.</p>
                        </div>
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINATION --}}
@if($pekaryas->hasPages())
    <div class="adm-pagination">
        {{ $pekaryas->links('admin.partials.pagination') }}
    </div>
@endif

@endsection
