@extends('layouts.admin')

@section('title', "Edit Galeri - S'Spotlight")

@section('content')



        <!-- HEADER -->

        <header class="page-header">

            <div>

                <h1>Edit Galeri</h1>

                <p>
                    Perbarui dokumentasi kegiatan atau prestasi siswa.
                </p>

            </div>

        </header>


        <!-- ================= FORM ================= -->

        <section class="form-section animate-on-scroll">

            <form
                action="{{ route('admin.galeri.update', $galeri->id_galeri) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="form-error">{{ $errors->first() }}</div>
                @endif

                <!-- JUDUL -->

                <div class="form-group">

                    <label>Judul Galeri</label>

                    <input
                        type="text"
                        name="judul"
                        value="{{ old('judul', $galeri->judul) }}"
                        placeholder="Masukkan judul galeri"
                    >

                </div>


                <!-- UPLOAD FOTO -->

                <div class="form-group">

                    <label>Foto Galeri</label>

                    @if ($galeri->gambar)
                        <div class="image-preview">
                            <img src="{{ asset('image/'.$galeri->gambar) }}" alt="{{ $galeri->judul }}">
                        </div>
                    @endif

                    <input
                        type="file"
                        name="gambar"
                        accept="image/*"
                    >

                    <small>
                        Kosongkan jika tidak ingin mengganti foto. Format: JPG, JPEG, atau PNG.
                    </small>

                </div>


                <!-- BUTTON -->

                <div class="form-actions">

                    <a href="{{ route('admin.galeri') }}" class="btn-cancel">
                        Batal
                    </a>


                    <button
                        type="submit"
                        class="btn-submit"
                    >
                        Simpan Perubahan
                    </button>

                </div>


            </form>

        </section>
@endsection
