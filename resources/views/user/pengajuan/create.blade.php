@extends('layouts.frontend')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <!-- Header -->
        <div class="mb-8" data-reveal>
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-butter-gold-100 border border-butter-gold-300/80 text-butter-gold-800 text-xs font-bold tracking-wider uppercase mb-4">
               
                Ajukan Karyamu
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-dark">
                Formulir Pengajuan Karya
            </h1>

            <p class="text-sm text-brand-muted mt-2">
                Isi data karyamu di bawah ini. Pengajuan akan ditinjau terlebih dahulu sebelum tampil di halaman Portofolio.
            </p>
        </div>

        <!-- Notifikasi sukses -->
        @if (session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Notifikasi error -->
        @if ($errors->any())
            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                <span class="material-symbols-outlined text-red-500">error</span>
                <div>
                    <p class="font-semibold mb-1">Pengajuan belum bisa dikirim:</p>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if ($errors->any())
            @include('partials.toast', ['toastError' => 'Pengajuan belum terkirim. Periksa kembali isian formulir.'])
        @endif

        <form action="{{ route('user.pengajuan.store') }}" method="POST" enctype="multipart/form-data"
              class="bg-white border border-warm-beige rounded-3xl shadow-soft p-6 sm:p-8 space-y-6" data-reveal="fade">
            @csrf

            <!-- Nama siswa -->
            <div>
                <label for="nama_siswa" class="block text-sm font-semibold mb-2">Nama Siswa</label>
                <input type="text" id="nama_siswa" name="nama_siswa" value="{{ old('nama_siswa') }}" required
                       placeholder="Masukkan nama lengkap"
                       class="w-full rounded-xl border border-warm-beige bg-off-white px-4 py-3 text-sm focus:outline-none focus:border-butter-gold-500 focus:ring-2 focus:ring-butter-gold-200 @error('nama_siswa') border-red-400 @enderror">
                @error('nama_siswa') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <!-- Kelas -->
            <div>
                <label for="kelas" class="block text-sm font-semibold mb-2">Kelas</label>
                <input type="text" id="kelas" name="kelas" value="{{ old('kelas') }}" required
                       placeholder="Contoh: XI RPL 1"
                       class="w-full rounded-xl border border-warm-beige bg-off-white px-4 py-3 text-sm focus:outline-none focus:border-butter-gold-500 focus:ring-2 focus:ring-butter-gold-200 @error('kelas') border-red-400 @enderror">
                @error('kelas') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <!-- Judul karya -->
            <div>
                <label for="judul_karya" class="block text-sm font-semibold mb-2">Judul Karya</label>
                <input type="text" id="judul_karya" name="judul_karya" value="{{ old('judul_karya') }}" required
                       placeholder="Masukkan judul karya"
                       class="w-full rounded-xl border border-warm-beige bg-off-white px-4 py-3 text-sm focus:outline-none focus:border-butter-gold-500 focus:ring-2 focus:ring-butter-gold-200 @error('judul_karya') border-red-400 @enderror">
                @error('judul_karya') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <!-- Kategori -->
            <div>
                <label for="kategori" class="block text-sm font-semibold mb-2">Kategori Karya</label>
                <select id="kategori" name="kategori" required
                        class="w-full rounded-xl border border-warm-beige bg-off-white px-4 py-3 text-sm focus:outline-none focus:border-butter-gold-500 focus:ring-2 focus:ring-butter-gold-200 @error('kategori') border-red-400 @enderror">
                    <option value="">Pilih kategori</option>
                    <option value="Web" {{ old('kategori') == 'Web' ? 'selected' : '' }}>Web</option>
                    <option value="Apk" {{ old('kategori') == 'Apk' ? 'selected' : '' }}>Aplikasi</option>
                    <option value="Desain" {{ old('kategori') == 'Desain' ? 'selected' : '' }}>Desain</option>
                    <option value="Gambar" {{ old('kategori') == 'Gambar' ? 'selected' : '' }}>Gambar</option>
                </select>
                @error('kategori') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-semibold mb-2">Deskripsi Karya</label>
                <textarea id="deskripsi" name="deskripsi" rows="5" required
                          placeholder="Ceritakan tentang karyamu: tujuan, proses, dan hasilnya dan lampirkan link karyamu (jika ada)"
                          class="w-full rounded-xl border border-warm-beige bg-off-white px-4 py-3 text-sm focus:outline-none focus:border-butter-gold-500 focus:ring-2 focus:ring-butter-gold-200 @error('deskripsi') border-red-400 @enderror">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <!-- Upload gambar -->
            <div>
                <label for="gambar" class="block text-sm font-semibold mb-2">Gambar Karya</label>
                <input type="file" id="gambar" name="gambar" accept="image/png,image/jpeg,image/webp" required
                       class="w-full rounded-xl border border-dashed border-warm-beige bg-off-white px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-butter-gold-400 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-brand-dark hover:file:bg-butter-gold-500 @error('gambar') border-red-400 @enderror">
                <p class="text-xs text-brand-muted mt-1.5">Format JPG, PNG, atau WEBP. Maksimal 2 MB.</p>
                @error('gambar') <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p> @enderror
            </div>

            <!-- Tombol -->
            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-2">
                <a href="{{ route('user.beranda') }}"
                   class="inline-flex items-center justify-center px-6 py-3 rounded-2xl bg-white border-2 border-warm-beige text-brand-dark font-semibold text-sm hover:bg-warm-beige-light transition-all">
                    Kembali
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-7 py-3 rounded-2xl bg-butter-gold-500 text-white font-bold text-sm hover:bg-butter-gold-600 hover:shadow-lg transition-all">
                    <span class="material-symbols-outlined text-xl">send</span>
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
@endsection
