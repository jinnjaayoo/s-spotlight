@extends('layouts.admin')

@section('title', "Data Portofolio - S'Spotlight")

@section('content')



        <!-- HEADER -->

        <header class="page-header">

            <div>

                <h1>Data Portofolio</h1>

                <p>
                    Kelola data portofolio dan prestasi siswa.
                </p>

            </div>


            <!-- NANTI DIHUBUNGKAN KE HALAMAN CREATE -->

            <a href="{{ route ('admin.createport') }}" class="btn-add">

                + Tambah Portofolio

            </a>

        </header>


        <!-- =========================
             PORTFOLIO TABLE SECTION
        ========================== -->

        <section class="data-section">

            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <!-- SEARCH & FILTER -->

            <form method="GET" action="{{ route('admin.porto') }}" class="table-toolbar">

                <div class="search-box">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari portofolio..."
                    >

                    <button type="submit" class="search-submit" aria-label="Cari">⌕</button>

                </div>


                <!-- FILTER -->

                <select class="filter-select" name="kategori" onchange="this.form.submit()">

                    <option value="">
                        Semua Kategori
                    </option>

                    <option value="Web" {{ request('kategori') == 'Web' ? 'selected' : '' }}>
                        Web
                    </option>

                    <option value="Apk" {{ request('kategori') == 'Apk' ? 'selected' : '' }}>
                        Apk
                    </option>

                    <option value="Desain" {{ request('kategori') == 'Desain' ? 'selected' : '' }}>
                        Desain
                    </option>

                    <option value="Gambar" {{ request('kategori') == 'Gambar' ? 'selected' : '' }}>
                        Gambar
                    </option>

                </select>

            </form>


            <!-- TABLE -->

            <div class="table-wrapper">

                <table class="data-table">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Portofolio</th>

                            <th>Nama Siswa</th>

                            <th>Kategori</th>

                            <th>Teknologi</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

    @forelse ($portofolios as $portofolio)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>

                <div class="portfolio-cell">

                    <div class="portfolio-thumbnail">

                        @if ($portofolio->gambar)
                            <img
                                src="{{ asset('image/' . $portofolio->gambar) }}"
                                alt="{{ $portofolio->nama_portofolio }}"
                            >
                        @else
                            🏆
                        @endif

                    </div>

                    <div>

                        <h4>
                            {{ $portofolio->nama_portofolio }}
                        </h4>

                        <p>
                            {{ Str::limit(strip_tags($portofolio->deskripsi ?? ''), 90) }}
                        </p>

                    </div>

                </div>

            </td>

            <td>
                {{ $portofolio->nama_siswa }}
            </td>

            <td>

                <span class="badge {{ strtolower(str_replace(' ', '-', $portofolio->kategori ?? '')) }}">

                    {{ $portofolio->kategori ?? '-' }}

                </span>

            </td>

            <td>
                {{ $portofolio->teknologi ?? '-' }}
            </td>

            <td>

                <div class="action-buttons">

                    <a href="{{ route('admin.porto.edit', $portofolio->id_portofolio) }}" class="btn-edit">
                        Edit
                    </a>

                    <form action="{{ route('admin.porto.destroy', $portofolio->id_portofolio) }}" method="POST" onsubmit="return confirm('Mau di hapus perasaan nya?');">
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
                    Tidak ada portofolio yang cocok dengan pencarian/filter.
                @else
                    Belum ada data portofolio.
                @endif

            </td>

        </tr>

    @endforelse

</tbody>
                </table>

            </div>


            <!-- =========================
                 PAGINATION
            ========================== -->

            {{ $portofolios->onEachSide(1)->links('admin.partials.pagination') }}


        </section>
@endsection
