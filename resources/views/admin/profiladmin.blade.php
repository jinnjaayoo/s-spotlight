@extends('layouts.admin')

@section('title', "Profil Admin - S'Spotlight")

@section('content')

    <header class="page-header">

        <div>
            <h1>Profil Admin</h1>
            <p>Kelola informasi akun dan profil administrator.</p>
        </div>

    </header>


    <section class="profile-section animate-on-scroll">

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="form-error">{{ $errors->first() }}</div>
            @endif

            <div class="profile-photo-block">

                <div class="profile-photo-preview">
                    @if ($admin->foto)
                        <img src="{{ asset('image/'.$admin->foto) }}" alt="{{ $admin->name }}">
                    @else
                        <span>{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                    @endif
                </div>

                <div class="profile-photo-input">
                    <label>Foto Profil</label>
                    <input type="file" name="foto" accept="image/*">
                    <small>Format: JPG, JPEG, atau PNG. Kosongkan jika tidak ingin mengganti foto.</small>
                </div>

            </div>

            <div class="form-group">
                <label>Nama Admin</label>
                <input type="text" name="name" value="{{ old('name', $admin->name) }}" placeholder="Masukkan nama admin">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}" placeholder="Masukkan email">
            </div>

            <div class="form-group">
                <label>Keterangan / Bio</label>
                <textarea name="keterangan" rows="4" placeholder="Ceritakan sedikit tentang admin ini...">{{ old('keterangan', $admin->keterangan) }}</textarea>
            </div>

            <hr class="profile-divider">

            <p class="profile-section-label">Ganti Password (opsional)</p>

            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengganti password">
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </div>

        </form>

    </section>

@endsection
