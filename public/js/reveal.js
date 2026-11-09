/* =========================================================
   S'Spotlight — Scroll Reveal (tanpa library)
   ---------------------------------------------------------
   File ini SENGAJA dimuat di <head> tanpa defer supaya class
   `js-reveal` menempel sebelum <body> dirender. Itu mencegah
   konten sempat terlihat lalu mendadak hilang (flicker).

   Aman kalau gagal: kalau file ini tidak termuat, class
   `js-reveal` tidak pernah ada dan reveal.css tidak
   menyembunyikan apa pun.
   ========================================================= */
(function () {
    'use strict';

    var doc = document.documentElement;

    // --- 1. Jangan animasikan sama sekali jika tidak pantas ---------------
    var prefersReduced =
        window.matchMedia &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (prefersReduced || !('IntersectionObserver' in window)) {
        return; // konten tampil normal, tidak ada yang disembunyikan
    }

    doc.classList.add('js-reveal');

    // Kalau ada error tak terduga, tampilkan semuanya.
    function bail() {
        doc.classList.add('reveal-failed');
    }

    var SELECTOR = '[data-reveal], [data-reveal-group] > *';
    var observer = null;

    function markRevealed(el, delayMs) {
        if (delayMs) {
            el.style.transitionDelay = delayMs + 'ms';
        }
        el.classList.add('is-revealed');

        // Bersihkan sisa properti animasi setelah selesai supaya tidak
        // mengganggu hover/transform milik Tailwind pada kartu.
        window.setTimeout(function () {
            el.classList.add('reveal-done');
            el.style.transitionDelay = '';
        }, 700 + (delayMs || 0));
    }

    function init() {
        try {
            var targets = document.querySelectorAll(SELECTOR);

            if (!targets.length) {
                doc.classList.remove('js-reveal');
                return;
            }

            observer = new IntersectionObserver(
                function (entries) {
                    for (var i = 0; i < entries.length; i++) {
                        var entry = entries[i];
                        if (!entry.isIntersecting) continue;

                        var el = entry.target;
                        observer.unobserve(el);

                        // Stagger: hanya untuk anak dari sebuah grup.
                        var delay = 0;
                        var group = el.parentElement;

                        if (group && group.hasAttribute &&
                            group.hasAttribute('data-reveal-group')) {

                            var index = 0;
                            var sibling = el.previousElementSibling;
                            while (sibling) {
                                index++;
                                sibling = sibling.previousElementSibling;
                            }
                            // Dibatasi 5 langkah supaya grid panjang tidak
                            // menunggu lama (maksimal 400ms).
                            delay = Math.min(index, 5) * 80;
                        }

                        markRevealed(el, delay);
                    }
                },
                {
                    root: null,
                    // -8% supaya elemen benar-benar masuk dulu, tapi tidak
                    // terlalu dalam sehingga terasa telat.
                    rootMargin: '0px 0px -8% 0px',
                    threshold: 0.08
                }
            );

            for (var t = 0; t < targets.length; t++) {
                observer.observe(targets[t]);
            }

            /* Jaring pengaman:
               Elemen yang sudah berada di viewport tapi entah kenapa belum
               ter-reveal (mis. sempat display:none karena filter kategori,
               atau observer tidak pernah menembak) dipaksa tampil setelah
               2.5 detik. Ini mencegah konten "hilang" permanen. */
            window.setTimeout(function () {
                var stuck = document.querySelectorAll(
                    '[data-reveal]:not(.is-revealed), [data-reveal-group] > :not(.is-revealed)'
                );
                for (var s = 0; s < stuck.length; s++) {
                    var rect = stuck[s].getBoundingClientRect();
                    var visible =
                        rect.top < window.innerHeight &&
                        rect.bottom > 0 &&
                        rect.width > 0;

                    if (visible) {
                        if (observer) observer.unobserve(stuck[s]);
                        markRevealed(stuck[s], 0);
                    }
                }
            }, 2500);

        } catch (e) {
            bail();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Kalau halaman dibuka lewat tombol "back", browser bisa memulihkan
    // DOM dari bfcache dengan observer yang sudah mati. Paksa tampil.
    window.addEventListener('pageshow', function (event) {
        if (!event.persisted) return;
        var left = document.querySelectorAll(
            '[data-reveal]:not(.is-revealed), [data-reveal-group] > :not(.is-revealed)'
        );
        for (var i = 0; i < left.length; i++) {
            left[i].classList.add('is-revealed', 'reveal-done');
        }
    });
})();
