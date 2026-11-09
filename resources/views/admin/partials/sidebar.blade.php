<aside class="sidebar" id="adminSidebar">

    <div class="sidebar-top">

        <button type="button" class="sidebar-close" id="sidebarClose" aria-label="Tutup menu">
            ✕
        </button>

        <div class="sidebar-logo">
            <h2>S'<span>Spotlight</span></h2>
            <p>Admin Panel</p>
        </div>

    </div>


    <nav class="sidebar-menu">

        <a href="{{ route('admin.dasbor') }}"
            class="menu-item {{ request()->routeIs('admin.dasbor') ? 'active' : '' }}">
            <span><img src="{{ asset('images/Home.svg') }}" alt="Dashboard"></span>
            Dashboard
        </a>

        <a href="{{ route('admin.porto') }}" class="menu-item {{ request()->routeIs('admin.porto*') ? 'active' : '' }}">
            <span><img src="{{ asset('images/Folder.svg') }}" alt="Portofolio"></span>
            Portofolio
        </a>

        <a href="{{ route('admin.galeri') }}"
            class="menu-item {{ request()->routeIs('admin.galeri*') ? 'active' : '' }}">
            <span><img src="{{ asset('images/Image.svg') }}" alt="Galeri"></span>
            Galeri
        </a>

        <a href="{{ route('admin.info') }}" class="menu-item {{ request()->routeIs('admin.info*') ? 'active' : '' }}">
            <span><img src="{{ asset('images/Info.svg') }}" alt="Info Umum"></span>
            Info Umum
        </a>

        <a href="{{ route('admin.profile') }}"
            class="menu-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
            <span><img src="{{ asset('images/user.svg') }}" alt="Profil Admin"></span>
            Profil Admin
        </a>

    </nav>


    <div class="sidebar-bottom">

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <span><img src="{{ asset('images/Log out.svg') }}" alt="Logout"></span>
                Logout
            </button>
        </form>

    </div>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>