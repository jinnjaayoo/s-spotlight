/**
 * S'Spotlight — Frontend Interactive Script
 * Handles:
 * 1. Responsive Hamburger Navigation
 * 2. Scrolling Animations (Reveal, Sticky Navbar Effect, ScrollSpy, Smooth Scroll)
 * 3. Interactive Live Search Bar & Category Filter
 * 4. Gallery Slider Navigation
 */

document.addEventListener('DOMContentLoaded', () => {
    initMobileNav();
    initScrollEffects();
    initFilterAndSearch();
    initGallerySlider();
});

/* ==========================================================================
   1. RESPONSIVE HAMBURGER NAVIGATION
   ========================================================================== */
function initMobileNav() {
    const navbars = document.querySelectorAll('.navbar');

    navbars.forEach((navbar) => {
        const menuBtn = navbar.querySelector('.menu-button') || navbar.querySelector('.hamburger-btn');
        const menuToggle = navbar.querySelector('#menu-toggle');
        const navMenu = navbar.querySelector('.nav-menu');
        const closeBtn = navbar.querySelector('.drawer-close-btn');

        if (!navMenu) return;

        const openNav = () => {
            navbar.classList.add('nav-open');
            if (menuBtn) {
                menuBtn.classList.add('active');
                menuBtn.setAttribute('aria-expanded', 'true');
            }
            if (menuToggle) menuToggle.checked = true;
            document.body.classList.add('no-scroll');
        };

        const closeNav = () => {
            navbar.classList.remove('nav-open');
            if (menuBtn) {
                menuBtn.classList.remove('active');
                menuBtn.setAttribute('aria-expanded', 'false');
            }
            if (menuToggle) menuToggle.checked = false;
            document.body.classList.remove('no-scroll');
        };

        const toggleNav = () => {
            if (navbar.classList.contains('nav-open')) {
                closeNav();
            } else {
                openNav();
            }
        };

        if (menuBtn) {
            menuBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                toggleNav();
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                closeNav();
            });
        }

        if (menuToggle) {
            menuToggle.addEventListener('change', () => {
                if (menuToggle.checked) {
                    openNav();
                } else {
                    closeNav();
                }
            });
        }

        // Close mobile nav when clicking any nav link
        navMenu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                closeNav();
            });
        });

        // Close on outside click (clicking backdrop)
        document.addEventListener('click', (e) => {
            if (navbar.classList.contains('nav-open')) {
                if (!navMenu.contains(e.target) && !menuBtn.contains(e.target)) {
                    closeNav();
                }
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && navbar.classList.contains('nav-open')) {
                closeNav();
            }
        });
    });
}

/* ==========================================================================
   2. SCROLLING ANIMATIONS & EFFECTS
   ========================================================================== */
function initScrollEffects() {
    const navbar = document.querySelector('.navbar');

    // 2.1 Sticky Navbar elevation shadow on scroll
    if (navbar) {
        const updateNavbarScroll = () => {
            if (window.scrollY > 20) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        };
        window.addEventListener('scroll', updateNavbarScroll, { passive: true });
        updateNavbarScroll();
    }

    // 2.2 Smooth Scroll offset for in-page anchors
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#' || targetId === '') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                const navHeight = navbar ? navbar.offsetHeight : 0;
                const elementPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                const offsetPosition = elementPosition - navHeight - 12;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });

                if (history.pushState) {
                    history.pushState(null, null, targetId);
                }
            }
        });
    });

    // 2.3 ScrollSpy for Beranda Page
    const berandaSections = document.querySelectorAll('main section[id]');
    const berandaNavLinks = document.querySelectorAll('.nav-menu a[href^="#"]');

    if (berandaSections.length > 0 && berandaNavLinks.length > 0) {
        const updateScrollSpy = () => {
            const scrollPos = window.scrollY + 140;
            berandaSections.forEach((sec) => {
                const top = sec.offsetTop;
                const height = sec.offsetHeight;
                const id = sec.getAttribute('id');

                if (scrollPos >= top && scrollPos < top + height) {
                    berandaNavLinks.forEach((link) => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === `#${id}`) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        };
        window.addEventListener('scroll', updateScrollSpy, { passive: true });
    }

    // 2.4 Intersection Observer for Scroll Reveal Animations
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const revealTargets = document.querySelectorAll(
        '.reveal, .hero-copy, .hero-visual, .portfolio-card, .gallery-item, .info-card, .about-image, .about-copy, .news-card, .vision-card, .gallery-card'
    );

    if (prefersReducedMotion) {
        revealTargets.forEach((el) => el.classList.add('reveal-active'));
        return;
    }

    if ('IntersectionObserver' in window) {
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -40px 0px',
            threshold: 0.1
        };

        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const parentGrid = el.closest('.portfolio-grid, .gallery-grid, .info-grid, .news-grid, .vision-grid');
                    if (parentGrid) {
                        const siblings = Array.from(parentGrid.children);
                        const index = siblings.indexOf(el);
                        el.style.transitionDelay = `${(index % 4) * 0.08}s`;
                    }
                    el.classList.add('reveal-active');
                    observer.unobserve(el);
                }
            });
        }, observerOptions);

        revealTargets.forEach((el) => {
            el.classList.add('reveal');
            revealObserver.observe(el);
        });
    } else {
        revealTargets.forEach((el) => el.classList.add('reveal-active'));
    }
}

/* ==========================================================================
   3. INTERACTIVE LIVE SEARCH BAR & CATEGORY FILTERS
   ========================================================================== */
function initFilterAndSearch() {
    setupPortfolioFiltering();
    setupInfoFiltering();
    setupGalleryFiltering();
    setupBerandaFilters();
}

function setupPortfolioFiltering() {
    const searchBox = document.querySelector('.page-header .search-box');
    const filterContainer = document.querySelector('.filter-section');
    const grid = document.querySelector('.portfolio-grid');

    if (!grid) return;

    const cards = Array.from(grid.querySelectorAll('.portfolio-card'));
    if (cards.length === 0) return;

    let emptyState = document.getElementById('portfolio-empty-state');
    if (!emptyState) {
        emptyState = document.createElement('div');
        emptyState.id = 'portfolio-empty-state';
        emptyState.className = 'search-empty-state';
        emptyState.innerHTML = `
            <div class="empty-icon">🔍</div>
            <h3>Tidak Ada Portofolio Ditemukan</h3>
            <p>Tidak ada karya atau prestasi yang sesuai dengan kata kunci pencarian.</p>
            <button type="button" class="btn btn-secondary reset-filter-btn">Reset Filter & Pencarian</button>
        `;
        emptyState.style.display = 'none';
        grid.parentNode.insertBefore(emptyState, grid.nextSibling);

        emptyState.querySelector('.reset-filter-btn')?.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            activeCategory = 'semua';
            filterButtons.forEach((b) => b.classList.remove('active'));
            const firstBtn = filterButtons[0];
            if (firstBtn) firstBtn.classList.add('active');
            updateSearchClearBtn();
            filterCards();
        });
    }

    const searchInput = searchBox ? searchBox.querySelector('input') : null;
    const filterButtons = filterContainer ? Array.from(filterContainer.querySelectorAll('.filter-btn, .filter')) : [];

    let clearBtn = null;
    if (searchBox && searchInput) {
        clearBtn = document.createElement('button');
        clearBtn.type = 'button';
        clearBtn.className = 'search-clear-btn';
        clearBtn.innerHTML = '&times;';
        clearBtn.setAttribute('aria-label', 'Hapus pencarian');
        clearBtn.style.display = 'none';
        searchBox.appendChild(clearBtn);

        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            searchInput.focus();
            updateSearchClearBtn();
            filterCards();
        });
    }

    function updateSearchClearBtn() {
        if (!clearBtn || !searchInput) return;
        clearBtn.style.display = searchInput.value.trim().length > 0 ? 'block' : 'none';
    }

    let activeCategory = 'semua';

    function filterCards() {
        const query = (searchInput ? searchInput.value : '').trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach((card) => {
            const title = (card.querySelector('h3')?.textContent || '').toLowerCase();
            const author = (card.querySelector('.portfolio-info p')?.textContent || '').toLowerCase();
            const badge = (card.querySelector('.badge')?.textContent || '').toLowerCase();
            const cardCategory = (card.getAttribute('data-category') || badge || '').toLowerCase();

            const matchesCategory =
                activeCategory === 'semua' ||
                (activeCategory === 'non akademik' ? (cardCategory.includes('non') || cardCategory.includes('non-akademik')) : (cardCategory.includes('akademik') && !cardCategory.includes('non')));

            const matchesSearch =
                query === '' ||
                title.includes(query) ||
                author.includes(query) ||
                cardCategory.includes(query);

            if (matchesCategory && matchesSearch) {
                card.style.display = '';
                card.classList.add('reveal-active');
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        const pagination = document.querySelector('.pagination');
        if (pagination) {
            pagination.style.display = query !== '' || activeCategory !== 'semua' ? 'none' : '';
        }
    }

    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            updateSearchClearBtn();
            debounceTimer = setTimeout(filterCards, 120);
        });

        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                searchInput.value = '';
                updateSearchClearBtn();
                filterCards();
            }
        });
    }

    filterButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            filterButtons.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');

            const btnText = btn.textContent.trim().toLowerCase();
            if (btnText.includes('non')) {
                activeCategory = 'non akademik';
            } else if (btnText.includes('akademik')) {
                activeCategory = 'akademik';
            } else {
                activeCategory = 'semua';
            }

            filterCards();
        });
    });
}

function setupInfoFiltering() {
    const searchBox = document.querySelector('.info-tools .search-box');
    const filterContainer = document.querySelector('.info-tools .filter-section');
    const grid = document.querySelector('.news-grid');

    if (!grid) return;

    const cards = Array.from(grid.querySelectorAll('.news-card'));
    if (cards.length === 0) return;

    let emptyState = document.getElementById('info-empty-state');
    if (!emptyState) {
        emptyState = document.createElement('div');
        emptyState.id = 'info-empty-state';
        emptyState.className = 'search-empty-state';
        emptyState.innerHTML = `
            <div class="empty-icon">📰</div>
            <h3>Tidak Ada Informasi Ditemukan</h3>
            <p>Tidak ada berita atau pengumuman yang cocok dengan pencarian Anda.</p>
            <button type="button" class="btn btn-secondary reset-filter-btn">Reset Filter & Pencarian</button>
        `;
        emptyState.style.display = 'none';
        grid.parentNode.insertBefore(emptyState, grid.nextSibling);

        emptyState.querySelector('.reset-filter-btn')?.addEventListener('click', () => {
            if (searchInput) searchInput.value = '';
            activeCategory = 'semua';
            filterButtons.forEach((b) => b.classList.remove('active'));
            const firstBtn = filterButtons[0];
            if (firstBtn) firstBtn.classList.add('active');
            updateSearchClearBtn();
            filterCards();
        });
    }

    const searchInput = searchBox ? searchBox.querySelector('input') : null;
    const filterButtons = filterContainer ? Array.from(filterContainer.querySelectorAll('.filter-btn')) : [];

    let clearBtn = null;
    if (searchBox && searchInput) {
        clearBtn = document.createElement('button');
        clearBtn.type = 'button';
        clearBtn.className = 'search-clear-btn';
        clearBtn.innerHTML = '&times;';
        clearBtn.setAttribute('aria-label', 'Hapus pencarian');
        clearBtn.style.display = 'none';
        searchBox.appendChild(clearBtn);

        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            searchInput.focus();
            updateSearchClearBtn();
            filterCards();
        });
    }

    function updateSearchClearBtn() {
        if (!clearBtn || !searchInput) return;
        clearBtn.style.display = searchInput.value.trim().length > 0 ? 'block' : 'none';
    }

    let activeCategory = 'semua';

    function filterCards() {
        const query = (searchInput ? searchInput.value : '').trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach((card) => {
            const category = (card.querySelector('.news-category')?.textContent || '').toLowerCase();
            const title = (card.querySelector('h2')?.textContent || '').toLowerCase();
            const content = (card.querySelector('p')?.textContent || '').toLowerCase();
            const cardCategory = (card.getAttribute('data-category') || category).toLowerCase();

            const matchesCategory =
                activeCategory === 'semua' ||
                cardCategory.includes(activeCategory);

            const matchesSearch =
                query === '' ||
                title.includes(query) ||
                content.includes(query) ||
                category.includes(query);

            if (matchesCategory && matchesSearch) {
                card.style.display = '';
                card.classList.add('reveal-active');
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            updateSearchClearBtn();
            debounceTimer = setTimeout(filterCards, 120);
        });

        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                searchInput.value = '';
                updateSearchClearBtn();
                filterCards();
            }
        });
    }

    filterButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            filterButtons.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');

            const btnText = btn.textContent.trim().toLowerCase();
            if (btnText.includes('berita')) {
                activeCategory = 'berita';
            } else if (btnText.includes('pengumuman')) {
                activeCategory = 'pengumuman';
            } else {
                activeCategory = 'semua';
            }

            filterCards();
        });
    });
}

function setupGalleryFiltering() {
    const searchBox = document.querySelector('.page-header .search-box');
    const slider = document.querySelector('.gallery-slider');

    if (!slider) return;

    const cards = Array.from(slider.querySelectorAll('.gallery-card'));
    if (cards.length === 0) return;

    let emptyState = document.getElementById('gallery-empty-state');
    if (!emptyState) {
        emptyState = document.createElement('div');
        emptyState.id = 'gallery-empty-state';
        emptyState.className = 'search-empty-state';
        emptyState.innerHTML = `
            <div class="empty-icon">🖼️</div>
            <h3>Tidak Ada Dokumentasi Ditemukan</h3>
            <p>Tidak ada foto galeri yang cocok dengan pencarian Anda.</p>
        `;
        emptyState.style.display = 'none';
        slider.parentNode.insertBefore(emptyState, slider.nextSibling);
    }

    const searchInput = searchBox ? searchBox.querySelector('input') : null;

    let clearBtn = null;
    if (searchBox && searchInput) {
        clearBtn = document.createElement('button');
        clearBtn.type = 'button';
        clearBtn.className = 'search-clear-btn';
        clearBtn.innerHTML = '&times;';
        clearBtn.setAttribute('aria-label', 'Hapus pencarian');
        clearBtn.style.display = 'none';
        searchBox.appendChild(clearBtn);

        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            searchInput.focus();
            updateSearchClearBtn();
            filterGallery();
        });
    }

    function updateSearchClearBtn() {
        if (!clearBtn || !searchInput) return;
        clearBtn.style.display = searchInput.value.trim().length > 0 ? 'block' : 'none';
    }

    function filterGallery() {
        const query = (searchInput ? searchInput.value : '').trim().toLowerCase();
        let visibleCount = 0;

        cards.forEach((card) => {
            const title = (card.querySelector('h3')?.textContent || '').toLowerCase();
            const matches = query === '' || title.includes(query);

            if (matches) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            updateSearchClearBtn();
            debounceTimer = setTimeout(filterGallery, 120);
        });

        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                searchInput.value = '';
                updateSearchClearBtn();
                filterGallery();
            }
        });
    }
}

function setupBerandaFilters() {
    // 1. Karya & Pencapaian Siswa filter
    const portfolioSection = document.querySelector('.section-portfolio');
    if (portfolioSection) {
        const filterBtns = portfolioSection.querySelectorAll('.filter-buttons .filter');
        const cards = portfolioSection.querySelectorAll('.portfolio-grid .portfolio-card');

        filterBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                filterBtns.forEach((b) => b.classList.remove('active'));
                btn.classList.add('active');

                const text = btn.textContent.trim().toLowerCase();
                cards.forEach((card) => {
                    const metaCategory = (card.querySelector('.card-meta span:last-child')?.textContent || '').toLowerCase();
                    const cardCategory = (card.getAttribute('data-category') || metaCategory).toLowerCase();

                    let match = true;
                    if (text.includes('non')) {
                        match = cardCategory.includes('non');
                    } else if (text.includes('akademik')) {
                        match = cardCategory.includes('akademik') && !cardCategory.includes('non');
                    }

                    if (match) {
                        card.style.display = '';
                        card.classList.add('reveal-active');
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    // 2. Info & Kabar Terbaru filter
    const infoSection = document.querySelector('#info.info-section');
    if (infoSection) {
        const filterBtns = infoSection.querySelectorAll('.filter-buttons .filter');
        const cards = infoSection.querySelectorAll('.info-grid .info-card');

        filterBtns.forEach((btn) => {
            btn.addEventListener('click', () => {
                filterBtns.forEach((b) => b.classList.remove('active'));
                btn.classList.add('active');

                const text = btn.textContent.trim().toLowerCase();
                cards.forEach((card) => {
                    const badge = (card.querySelector('.info-body span')?.textContent || '').toLowerCase();
                    const cardCategory = (card.getAttribute('data-category') || badge).toLowerCase();

                    let match = true;
                    if (text.includes('berita')) {
                        match = cardCategory.includes('berita');
                    } else if (text.includes('pengumuman')) {
                        match = cardCategory.includes('pengumuman');
                    }

                    if (match) {
                        card.style.display = '';
                        card.classList.add('reveal-active');
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }
}

function initGallerySlider() {
    const slider = document.querySelector('.gallery-slider');
    if (!slider) return;

    const leftBtn = slider.querySelector('.slider-btn.left');
    const rightBtn = slider.querySelector('.slider-btn.right');

    if (leftBtn) {
        leftBtn.addEventListener('click', () => {
            slider.scrollBy({ left: -320, behavior: 'smooth' });
        });
    }

    if (rightBtn) {
        rightBtn.addEventListener('click', () => {
            slider.scrollBy({ left: 320, behavior: 'smooth' });
        });
    }
}
