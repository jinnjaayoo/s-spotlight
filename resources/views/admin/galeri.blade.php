@extends('layouts.admin')

@section('title', "Data Galeri - S'Spotlight")

@section('content')


        <!-- HEADER -->
        <header class="page-header">

            <div>
                <h1>Data Galeri</h1>

                <p>
                    Kelola dokumentasi kegiatan dan prestasi siswa.
                </p>
            </div>

            <a href="{{ route ('admin.creategaleri') }}" class="btn-add">
                + Tambah Galeri
            </a>

        </header>


        <!-- CONTENT -->
        <section class="data-section">

            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <!-- SEARCH -->
            <form method="GET" action="{{ route('admin.galeri') }}" class="table-toolbar">

                <div class="search-box">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari galeri..."
                    >

                    <button type="submit" class="search-submit" aria-label="Cari">⌕</button>

                </div>

            </form>


            <!-- GALLERY GRID -->

            <div class="admin-gallery-grid">

                @forelse ($galeris as $galeri)

                    <div class="admin-gallery-card animate-on-scroll">

                        <div class="admin-gallery-image">
                            @if ($galeri->gambar)
                                <img src="{{ asset('image/'.$galeri->gambar) }}" alt="{{ $galeri->judul }}">
                            @else
                                📷
                            @endif
                        </div>

                        <div class="admin-gallery-content">

                            <h3>
                                {{ $galeri->judul }}
                            </h3>

                            <div class="gallery-card-footer">

                                <span>ID #{{ $galeri->id_galeri }}</span>

                                <div class="action-buttons">

                                    <a href="{{ route('admin.galeri.edit', $galeri->id_galeri) }}" class="btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.galeri.destroy', $galeri->id_galeri) }}" method="POST" onsubmit="return confirm('Hapus galeri ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">Hapus</button>
                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <p style="grid-column: 1/-1; text-align:center; padding: 30px; color: var(--gray);">
                        @if (request()->filled('search'))
                            Tidak ada galeri yang cocok dengan pencarian.
                        @else
                            Belum ada data galeri.
                        @endif
                    </p>

                @endforelse

            </div>

            {{ $galeris->links('admin.partials.pagination') }}

        </section>
@endsection
