{{--
    Toast notifikasi bersama (admin, login admin, dan halaman publik).

    Sumber pesan (hanya muncul bila benar-benar ada):
      - session('toast_success') / session('toast_error')  → di-flash oleh controller
      - $toastError / $toastSuccess                        → dikirim lewat @include(..., [...])

    Sengaja memakai key terpisah dari session('success') / session('error') agar
    alert inline yang sudah ada di halaman lain tidak berubah / tidak dobel.
    Pesan selalu di-escape ({{ }}); JS hanya mengatur animasi tampil & tutup.
--}}
@php
    $ssToasts = [];
    if (session('toast_success')) { $ssToasts[] = ['success', session('toast_success')]; }
    if (!empty($toastSuccess))    { $ssToasts[] = ['success', $toastSuccess]; }
    if (session('toast_error'))   { $ssToasts[] = ['error', session('toast_error')]; }
    if (!empty($toastError))      { $ssToasts[] = ['error', $toastError]; }
@endphp

@if (count($ssToasts))
    @once
        <style>
            .ss-toast-stack{position:fixed;right:24px;bottom:24px;z-index:2000;display:flex;flex-direction:column;gap:10px;width:min(380px,calc(100vw - 32px));pointer-events:none}
            .ss-toast{--ss-accent:#16a34a;--ss-accent-soft:#ecfdf3;pointer-events:auto;display:flex;align-items:flex-start;gap:12px;padding:13px 14px 13px 12px;background:#fff;border:1px solid #e7e2d6;border-left:4px solid var(--ss-accent);border-radius:12px;box-shadow:0 1px 2px rgba(28,27,25,.05),0 14px 32px -14px rgba(28,27,25,.28);color:#1c1b19;font-family:'Sora',system-ui,sans-serif;opacity:1;transform:none;transition:opacity .25s ease,transform .25s ease}
            .ss-toast.is-error{--ss-accent:#dc2626;--ss-accent-soft:#fef2f2}
            .ss-toast.is-enter,.ss-toast.is-leave{opacity:0;transform:translateY(8px)}
            .ss-toast-icon{flex:0 0 auto;display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:50%;background:var(--ss-accent-soft);color:var(--ss-accent)}
            .ss-toast-icon svg{width:16px;height:16px}
            .ss-toast-body{flex:1 1 auto;min-width:0;padding-top:1px}
            .ss-toast-title{margin:0;font-size:13.5px;font-weight:700;line-height:1.35}
            .ss-toast-msg{margin:2px 0 0;font-size:12.5px;line-height:1.5;color:#6b6862;word-break:break-word}
            .ss-toast-close{flex:0 0 auto;width:24px;height:24px;margin:-2px -2px 0 0;padding:0;border:0;border-radius:6px;background:transparent;color:#9ca3af;font-size:18px;line-height:1;cursor:pointer}
            .ss-toast-close:hover{background:#f4f0e8;color:#1c1b19}
            @media (max-width:640px){.ss-toast-stack{right:16px;bottom:16px}}
            @media (prefers-reduced-motion:reduce){.ss-toast{transition:none}}
        </style>
    @endonce

    <div class="ss-toast-stack" aria-live="polite">
        @foreach ($ssToasts as [$ssType, $ssMessage])
            <div class="ss-toast {{ $ssType === 'error' ? 'is-error' : '' }}"
                 role="{{ $ssType === 'error' ? 'alert' : 'status' }}"
                 data-ss-toast
                 data-ss-timeout="{{ $ssType === 'error' ? 7000 : 5000 }}">
                <span class="ss-toast-icon" aria-hidden="true">
                    @if ($ssType === 'error')
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8v5m0 3.5h.01M10.3 3.9L2.4 17.5A2 2 0 004.1 20.5h15.8a2 2 0 001.7-3L13.7 3.9a2 2 0 00-3.4 0z"/></svg>
                    @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
                    @endif
                </span>
                <div class="ss-toast-body">
                    <p class="ss-toast-title">{{ $ssType === 'error' ? 'Gagal' : 'Berhasil' }}</p>
                    <p class="ss-toast-msg">{{ $ssMessage }}</p>
                </div>
                <button type="button" class="ss-toast-close" data-ss-close aria-label="Tutup notifikasi">&times;</button>
            </div>
        @endforeach
    </div>

    <script>
        (function () {
            function init(toast) {
                    if (toast.hasAttribute('data-ss-init')) return;
                    toast.setAttribute('data-ss-init', '');
                    var timeout = parseInt(toast.getAttribute('data-ss-timeout'), 10) || 5000;
                    var timer = null;

                    function close() {
                        clearTimeout(timer);
                        toast.classList.add('is-leave');
                        setTimeout(function () {
                            if (toast.parentNode) toast.parentNode.removeChild(toast);
                        }, 280);
                    }
                    function start() { clearTimeout(timer); timer = setTimeout(close, timeout); }

                    toast.classList.add('is-enter');
                    requestAnimationFrame(function () {
                        requestAnimationFrame(function () { toast.classList.remove('is-enter'); });
                    });

                    var btn = toast.querySelector('[data-ss-close]');
                    if (btn) btn.addEventListener('click', close);
                    toast.addEventListener('mouseenter', function () { clearTimeout(timer); });
                    toast.addEventListener('mouseleave', start);
                    start();
                }
                document.querySelectorAll('[data-ss-toast]').forEach(init);
        })();
    </script>
@endif
