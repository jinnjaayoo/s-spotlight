@extends('layouts.admin')

@section('title', "Edit Info Umum - S'Spotlight")

@section('content')


        <header class="page-header">

            <div>

                <h1>Edit Info Umum</h1>

                <p>
                    Perbarui berita, pengumuman, atau agenda.
                </p>

            </div>

        </header>


        <section class="form-section animate-on-scroll">

            <form
                action="{{ route('admin.info.update', $info->id_info) }}"
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

                    <label>Judul Informasi</label>

                    <input
                        type="text"
                        name="judul"
                        value="{{ old('judul', $info->judul) }}"
                        placeholder="Masukkan judul informasi"
                    >

                </div>


                <!-- JENIS INFORMASI -->

                <div class="form-group">

                    <label>Jenis Informasi</label>

                    <select name="kategori">

                        <option value="">
                            Pilih jenis informasi
                        </option>

                        <option value="Berita" {{ old('kategori', $info->kategori) == 'Berita' ? 'selected' : '' }}>
                            Berita
                        </option>

                        <option value="Pengumuman" {{ old('kategori', $info->kategori) == 'Pengumuman' ? 'selected' : '' }}>
                            Pengumuman
                        </option>

                        <option value="Agenda" {{ old('kategori', $info->kategori) == 'Agenda' ? 'selected' : '' }}>
                            Agenda
                        </option>

                    </select>

                </div>


                <!-- TANGGAL -->

                <div class="form-group">

                    <label>Tanggal</label>

                    <input
                        type="date"
                        name="tanggal"
                        value="{{ old('tanggal', optional($info->tanggal)->format('Y-m-d')) }}"
                    >

                </div>


                <!-- STATUS -->

                <div class="form-group">

                    <label>Status</label>

                    <select name="status">

                        <option value="draft" {{ old('status', $info->status) == 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>

                        <option value="published" {{ old('status', $info->status) == 'published' ? 'selected' : '' }}>
                            Dipublikasikan
                        </option>

                    </select>

                </div>


                <!-- GAMBAR -->

                <div class="form-group">

                    <label>Gambar Cover</label>

                    @if ($info->gambar)
                        <div class="image-preview">
                            <img src="{{ asset('image/'.$info->gambar) }}" alt="{{ $info->judul }}">
                        </div>
                    @endif

                    <input
                        type="file"
                        name="gambar"
                        accept="image/*"
                    >

                    <small>
                        Kosongkan jika tidak ingin mengganti gambar. Format: JPG, JPEG, atau PNG.
                    </small>

                </div>


                <!-- ISI INFORMASI -->

                <div class="form-group">

                    <label>Isi Informasi</label>

                    <textarea
                        id="info-editor"
                        name="isi"
                    >{{ old('isi', $info->isi) }}</textarea>

                </div>


                <!-- BUTTON -->

                <div class="form-actions">

                    <a href="{{ route('admin.info') }}" class="btn-cancel">
                        Batal
                    </a>

                    <button type="submit" class="btn-submit">
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </section>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs5.min.js"></script>

<script>
$(document).ready(function() {
    $('#info-editor').summernote({
        placeholder: 'Tulis isi informasi di sini...',
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
