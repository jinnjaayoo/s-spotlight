@extends('layouts.admin')

@section('title', "Dashboard Admin - S'Spotlight")

@section('content')



    <!-- HEADER -->

    <header class="admin-header">

        <div>
            <h1>Dashboard</h1>
            <p>Selamat datang di halaman admin S'Spotlight</p>
        </div>


        <a href="{{ route('admin.profile') }}" class="admin-profile">

            <div class="admin-avatar">
                @if (auth('admin')->user()->foto)
                    <img src="{{ asset('image/' . auth('admin')->user()->foto) }}" alt="{{ auth('admin')->user()->name }}">
                @else
                    {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}
                @endif
            </div>

            <div>
                <h4>{{ auth('admin')->user()->name }}</h4>
                <p>Administrator</p>
            </div>

        </a>

    </header>


    <!-- ================= CONTENT ================= -->

    <section class="dashboard-content">



        <!-- STATISTIK -->

        <div class="stats-grid">


            <div class="stat-card animate-on-scroll">

                <div class="stat-icon">
                    <img src="{{ asset('images/porto.svg') }}" alt="Portofolio">
                </div>

                <div class="stat-info">
                    <p>Total Portofolio</p>
                    <h2>{{ $totalPortofolio }}</h2>
                </div>

            </div>


            <div class="stat-card animate-on-scroll">

                <div class="stat-icon">
                    <img src="{{ asset('images/gale.svg') }}" alt="Galeri">
                </div>

                <div class="stat-info">
                    <p>Total Galeri</p>
                    <h2>{{ $totalGaleri }}</h2>
                </div>

            </div>


            <div class="stat-card animate-on-scroll">

                <div class="stat-icon">
                    <img src="{{ asset('images/infou.svg') }}" alt="Info Umum">
                </div>

                <div class="stat-info">
                    <p>Info Umum</p>
                    <h2>{{ $totalInfo }}</h2>
                </div>

            </div>


        </div>


        <!-- AKTIVITAS -->

        <div class="activity-section">

            <div class="section-title">

                <div>
                    <h2>Aktivitas Terbaru</h2>
                    <p>Aktivitas terbaru pada sistem</p>
                </div>

            </div>


            @if ($activities->count())

                <div class="activity-list">

                    @foreach ($activities as $activity)
                        <div class="activity-item animate-on-scroll">

                            <div class="activity-icon">
                                <img src="{{ asset('images/' . $activity['icon']) }}" alt="{{ $activity['title'] }}">
                            </div>

                            <div class="activity-info">

                                <h4>{{ $activity['title'] }}</h4>

                                <p>{{ $activity['description'] }}</p>

                            </div>

                            <span class="activity-time">
                                {{ $activity['time'] ? $activity['time']->diffForHumans() : '-' }}
                            </span>

                        </div>
                    @endforeach

                </div>

            @else

                <div class="empty-activity">

                    <div class="empty-icon">
                        📭
                    </div>

                    <h3>Belum ada aktivitas</h3>

                    <p>
                        Aktivitas akan muncul ketika Anda mulai
                        menambahkan data ke sistem.
                    </p>

                </div>

            @endif

        </div>


    </section>
@endsection