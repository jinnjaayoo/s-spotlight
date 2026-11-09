<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin - S'Spotlight</title>

    <!-- Font Sora -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body class="login-body">

    <div class="login-container">

        <!-- BAGIAN KIRI -->
        <div class="login-brand">

            <div class="brand-content">

                <!-- LOGO -->
                <h1>S'Spotlight</h1>

                <h2>Ruang Prestasi<br>SMKN 2 Purwakarta</h2>

                <p>
                    Kelola portofolio, galeri, dan informasi
                    prestasi siswa dalam satu tempat.
                </p>

            </div>

        </div>


        <!-- BAGIAN KANAN -->
        <div class="login-form-container">

            <div class="login-form">

                <h2>Selamat Datang!</h2>

                <p class="login-subtitle">
                    Masuk ke dashboard admin S'Spotlight
                </p>


                @if ($errors->any())
                    <div class="form-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf

                    <!-- EMAIL -->
                    <div class="form-group">

                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Masukkan email"
                            required
                            autofocus
                        >

                    </div>


                    <!-- PASSWORD -->
                    <div class="form-group">

                        <label>Password</label>

                        <input
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                        >

                    </div>


                    <!-- BUTTON LOGIN -->
                    <button type="submit" class="btn-login">

                        Masuk

                    </button>

                </form>


                <p class="login-footer">
                    © 2026 S'Spotlight — SMKN 2 Purwakarta
                </p>

            </div>

        </div>

    </div>

</body>
</html>