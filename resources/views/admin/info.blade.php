@extends('layouts.admin')

@section('title', "Info Umum - S'Spotlight")

@section('content')



        <!-- HEADER -->

        <header class="page-header">

            <div>

                <h1>Info Umum</h1>

                <p>
                    Kelola informasi, berita, pengumuman, dan agenda.
                </p>

            </div>


            <a href="{{ route('admin.createinfo') }}" class="btn-add">
                + Tambah Info
            </a>

        </header>


        <!-- ================= CONTENT ================= -->

        <section class="data-section">

            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <!-- TOOLBAR -->

            <form method="GET" action="{{ route('admin.info') }}" class="table-toolbar">

                <!-- SEARCH -->

                <div class="search-box">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari informasi..."
                    >

                    <button type="submit" class="search-submit" aria-label="Cari">⌕</button>

                </div>


                <!-- FILTER -->

                <select class="filter-select" name="kategori" onchange="this.form.submit()">

                    <option value="">
                        Semua Jenis
                    </option>

                    <option value="Berita" {{ request('kategori') == 'Berita' ? 'selected' : '' }}>
                        Berita
                    </option>

                    <option value="Pengumuman" {{ request('kategori') == 'Pengumuman' ? 'selected' : '' }}>
                        Pengumuman
                    </option>

                </select>

            </form>


            <!-- ================= TABLE ================= -->

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Judul Informasi</th>

                            <th>Jenis</th>

                            <th>Tanggal</th>

                            <th>Status</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse ($infos as $info)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>

                                <div class="info-title">

                                    <h4>
                                        {{ $info->judul }}
                                    </h4>

                                    <p>
                                        {{ Str::limit(strip_tags($info->isi), 80) }}
                                    </p>

                                </div>

                            </td>


                            <td>

                                <span class="info-badge {{ strtolower($info->kategori ?? '') }}">
                                    {{ $info->kategori ?? '-' }}
                                </span>

                            </td>


                            <td>
                                {{ $info->tanggal ? $info->tanggal->translatedFormat('d F Y') : '-' }}
                            </td>


                            <td>

                                <span class="status-badge {{ $info->status }}">
                                    {{ $info->status === 'published' ? 'Dipublikasikan' : 'Draft' }}
                                </span>

                            </td>


                            <td>

                                <div class="action-buttons">

                                    <a href="{{ route('admin.info.edit', $info->id_info) }}" class="btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.info.destroy', $info->id_info) }}" method="POST" onsubmit="return confirm('Hapus informasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Hapus</button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px;">
                                @if (request()->filled('search') || request()->filled('kategori'))
                                    Tidak ada informasi yang cocok dengan pencarian/filter.
                                @else
                                    Belum ada data informasi.
                                @endif
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            {{ $infos->links('admin.partials.pagination') }}

        </section>
@endsection
