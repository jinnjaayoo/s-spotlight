@extends('layouts.admin')

@section('title', "Tambah Portofolio - S'Spotlight")

@section('content')



    <!-- HEADER -->

    <header class="page-header">

        <div>

            <h1>Tambah Portofolio</h1>

            <p>
                Tambahkan data portofolio atau prestasi siswa.
            </p>

        </div>

    </header>


    <!-- ================= FORM ================= -->

    <section class="form-section animate-on-scroll">

        <form action="{{ route('admin.porto.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
                <div class="form-error">{{ $errors->first() }}</div>
            @endif

            <!-- JUDUL -->

            <div class="form-group">

                <label>Judul Portofolio</label>

                <input type="text" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul portofolio">

            </div>


            <!-- NAMA SISWA -->

            <div class="form-group">

                <label>Nama Siswa</label>

                <input type="text" name="nama_siswa" value="{{ old('nama_siswa') }}" placeholder="Masukkan nama siswa">

            </div>


            <!-- KATEGORI -->

            <div class="form-group">

                <label>Kategori</label>

                <select name="kategori">

                    <option value="">
                        Pilih kategori
                    </option>

                    <option value="Web" {{ old('kategori') == 'Web' ? 'selected' : '' }}>
                        Web
                    </option>

                    <option value="Apk" {{ old('kategori') == 'Apk' ? 'selected' : '' }}>
                        Aplikasi
                    </option>

                    <option value="Desain" {{ old('kategori') == 'Desain' ? 'selected' : '' }}>
                        Desain
                    </option>

                    <option value="Gambar" {{ old('kategori') == 'Gambar' ? 'selected' : '' }}>
                        Gambar
                    </option>

                </select>

            </div>


            <!-- TEKNOLOGI -->

            <div class="form-group">

                <label for="teknologi">Teknologi / Tools</label>

                <input type="text" id="teknologi" name="teknologi"
                    placeholder="Contoh: Laravel, PHP, MySQL"
                    value="{{ old('teknologi') }}">

            </div>


            <!-- LINK KARYA -->

            <div class="form-group">

                <label for="link_portofolio">Link Karya / Demo Website</label>

                <input type="url" id="link_portofolio" name="link_portofolio"
                    placeholder="https://contoh.com"
                    value="{{ old('link_portofolio') }}">

                <small>
                    Opsional. Harus diawali http:// atau https://
                </small>

            </div>

            
            <!-- FOTO -->

            <div class="form-group">

                <label>Foto / Thumbnail Portofolio</label>

                <input type="file" name="gambar" accept="image/*">

                <small>
                    Format gambar: JPG, JPEG, PNG.
                </small>

            </div>


            <!-- DESKRIPSI -->

            <div class="form-group">

                <label>Deskripsi Portofolio</label>

                <textarea id="portfolio-editor" name="deskripsi"></textarea>

            </div>


            <!-- BUTTON -->

            <div class="form-actions">

                <a href="{{ route('admin.porto') }}" class="btn-cancel">

                    Batal

                </a>


                <button type="submit" class="btn-submit">

                    Simpan Portofolio

                </button>

            </div>

        </form>

    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#portfolio-editor').summernote({
                placeholder: 'Tulis deskripsi portofolio di sini...',
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview', 'help']]
                ]
            });
        });
    </script>
@endsection