@extends('layouts.admin')

@section('title', "Tambah Galeri - S'Spotlight")

@section('content')



        <!-- HEADER -->

        <header class="page-header">

            <div>

                <h1>Tambah Galeri</h1>

                <p>
                    Tambahkan dokumentasi kegiatan atau prestasi siswa.
                </p>

            </div>

        </header>


        <!-- ================= FORM ================= -->

        <section class="form-section animate-on-scroll">

            <form
                action="{{ route('admin.galeri.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                @if ($errors->any())
                    <div class="form-error">{{ $errors->first() }}</div>
                @endif

                <!-- JUDUL -->

                <div class="form-group">

                    <label>Judul Galeri</label>

                    <input
                        type="text"
                        name="judul"
                        value="{{ old('judul') }}"
                        placeholder="Masukkan judul galeri"
                    >

                </div>


                <!-- UPLOAD FOTO -->

                <div class="form-group">

                    <label>Foto Galeri</label>

                    <input
                        type="file"
                        name="gambar"
                        id="gambar"
                        accept="image/*"
                    >

                    <small>
                        Upload foto dokumentasi. Format: JPG, JPEG, atau PNG.
                    </small>

                </div>


                <!-- PREVIEW AREA -->

                <div class="image-preview" id="image-preview">

    <span id="preview-placeholder">
        🖼️
    </span>

    <p id="preview-text">
        Preview gambar akan muncul di sini
    </p>

    <img
        id="preview-image"
        src=""
        alt="Preview foto"
        style="display: none; max-width: 100%; max-height: 300px; object-fit: contain;"
    >

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
                        Simpan Galeri
                    </button>

                </div>


            </form>

        </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('gambar');
        const previewImage = document.getElementById('preview-image');
        const placeholder = document.getElementById('preview-placeholder');
        const previewText = document.getElementById('preview-text');

        input.addEventListener('change', function () {
            const file = this.files[0];

            if (file) {
                const imageUrl = URL.createObjectURL(file);

                previewImage.src = imageUrl;
                previewImage.style.display = 'block';

                placeholder.style.display = 'none';
                previewText.style.display = 'none';
            } else {
                previewImage.src = '';
                previewImage.style.display = 'none';

                placeholder.style.display = 'inline';
                previewText.style.display = 'block';
            }
        });
    });
</script>
@endpush