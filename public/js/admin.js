document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       Sidebar toggle (hamburger) — mobile off-canvas
       ============================================================ */
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var openBtn = document.getElementById('sidebarToggle');
    var closeBtn = document.getElementById('sidebarClose');

    function openSidebar() {
        if (sidebar) sidebar.classList.add('is-open');
        if (overlay) overlay.classList.add('is-open');
    }

    function closeSidebar() {
        if (sidebar) sidebar.classList.remove('is-open');
        if (overlay) overlay.classList.remove('is-open');
    }

    if (openBtn) openBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    /* --- Tambahan aksesibilitas & anti-bug (tidak mengubah logika di atas) ---
       Semua di bawah ini hanya MEMANGGIL closeSidebar()/openSidebar() yang
       sudah ada; class 'is-open' tetap satu-satunya penanda status. */

    // Tutup dengan tombol Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sidebar && sidebar.classList.contains('is-open')) {
            closeSidebar();
        }
    });

    // Kalau layar dibesarkan ke ukuran desktop saat sidebar terbuka,
    // overlay bisa tertinggal dan menutupi konten. Bersihkan.
    var resizeTimer = null;
    window.addEventListener('resize', function () {
        window.clearTimeout(resizeTimer);
        resizeTimer = window.setTimeout(function () {
            if (window.innerWidth > 900) closeSidebar();
        }, 150);
    });

    // Status untuk pembaca layar
    if (openBtn) openBtn.setAttribute('aria-expanded', 'false');
    if (sidebar) {
        var syncAria = function () {
            if (openBtn) {
                openBtn.setAttribute(
                    'aria-expanded',
                    sidebar.classList.contains('is-open') ? 'true' : 'false'
                );
            }
        };
        if (openBtn) openBtn.addEventListener('click', syncAria);
        if (closeBtn) closeBtn.addEventListener('click', syncAria);
        if (overlay) overlay.addEventListener('click', syncAria);
    }

    // Close sidebar automatically when a menu link is tapped (mobile)
    if (sidebar) {
        sidebar.querySelectorAll('.menu-item, .logout-btn').forEach(function (el) {
            el.addEventListener('click', function () {
                if (window.innerWidth <= 900) closeSidebar();
            });
        });
    }

    /* ============================================================
       Scroll-reveal animation
       ============================================================ */
    var animatedEls = document.querySelectorAll('.animate-on-scroll');

    if ('IntersectionObserver' in window && animatedEls.length) {
        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        animatedEls.forEach(function (el) {
            observer.observe(el);
        });
    } else {
        // Fallback: just show everything if IntersectionObserver isn't supported
        animatedEls.forEach(function (el) {
            el.classList.add('is-visible');
        });
    }

    /* ============================================================
       Pratinjau gambar sebelum diunggah
       ------------------------------------------------------------
       Hanya berjalan kalau di halaman ada <input type="file"> DAN
       elemen .image-preview. Tidak mengubah nama input, validasi,
       maupun proses unggah di server.
       ============================================================ */
    document.querySelectorAll('input[type="file"][accept*="image"]').forEach(function (input) {
        var form = input.closest('form');
        if (!form) return;

        var preview = form.querySelector('.image-preview');
        if (!preview) return;

        var img = preview.querySelector('img');

        input.addEventListener('change', function () {
            var file = input.files && input.files[0];
            if (!file || !/^image\//.test(file.type)) return;

            if (!img) {
                img = document.createElement('img');
                preview.appendChild(img);
            }

            var reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                preview.style.display = '';
            };
            reader.readAsDataURL(file);
        });
    });
});
