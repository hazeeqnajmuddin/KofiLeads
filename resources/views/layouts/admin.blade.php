<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') — Rahmah Consulting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.jpeg') }}">
</head>
<body class="bg-slate-100 text-slate-900 font-sans antialiased min-h-screen flex flex-col">

{{-- Flash notifications (success / error / validation) --}}
@include('partials.flash')

<!-- Top Nav -->
@php
$adminLinks = [
    ['route' => 'admin.dashboard',  'label' => 'Papan Pemuka'],
    ['route' => 'admin.permohonan', 'label' => 'Permohonan'],
    ['route' => 'admin.laporan',    'label' => 'Laporan'],
    ['route' => 'admin.landing',    'label' => 'Tetapan Laman'],
];
@endphp
<nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 flex items-center justify-between h-16 gap-3">

        <!-- Left: Logo -->
        <div class="flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo4.png') }}" alt="Rahmah Consultancy Services" class="h-11 sm:h-30 w-auto">
            </a>
        </div>

        <!-- Center: Nav links (desktop) -->
        <div class="hidden md:flex items-center gap-1 flex-1 justify-center">
            @foreach($adminLinks as $link)
            <a href="{{ route($link['route']) }}"
               class="px-4 py-1.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs($link['route']) ? 'bg-navy text-white' : 'text-navy/60 hover:text-navy hover:bg-slate-100' }}">
                {{ $link['label'] }}
            </a>
            @endforeach
        </div>

        <!-- Right: date + site link + profile + hamburger -->
        <div class="flex items-center gap-2 sm:gap-4 flex-shrink-0">
            <span class="text-slate-400 text-xs hidden lg:block">{{ now()->format('d M Y') }}</span>
            <a href="/" target="_blank" class="text-gold hover:text-navy text-xs font-medium transition hidden lg:block">Lihat Laman →</a>

            <!-- User profile dropdown -->
            <div class="relative" id="admin-profile-wrapper">
                <button type="button" id="admin-profile-btn" onclick="toggleProfileMenu()"
                        class="flex items-center gap-2.5 bg-slate-100 hover:bg-slate-200 border border-slate-200 hover:border-slate-300 active:bg-slate-200 transition-all duration-150 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 select-none group">
                    <div class="w-7 h-7 rounded-md bg-navy flex items-center justify-center text-white text-xs font-black shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden sm:flex flex-col leading-none gap-0.5">
                        <span class="text-navy text-xs font-semibold tracking-tight">{{ auth()->user()->name ?? 'Admin' }}</span>
                        <span class="text-slate-400 text-[10px]">Administrator</span>
                    </div>
                    <svg class="hidden sm:block w-3.5 h-3.5 text-slate-400 group-hover:text-navy transition ml-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown panel -->
                <div id="admin-profile-menu"
                     class="hidden absolute right-0 top-full mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-xl py-1 z-[100]">
                    <a href="{{ route('admin.akaun') }}"
                       class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 transition">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Urus Akaun
                    </a>
                    <div class="border-t border-slate-100 my-1"></div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Log Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Hamburger (mobile) -->
            <button type="button" onclick="toggleAdminMenu()" aria-label="Menu"
                    class="md:hidden w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 text-navy hover:bg-slate-100 transition">
                <svg id="admin-menu-open" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="admin-menu-close" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

    </div>

    <!-- Mobile menu -->
    <div id="admin-mobile-menu" class="md:hidden hidden border-t border-slate-100 bg-white px-4 py-3 space-y-1">
        @foreach($adminLinks as $link)
        <a href="{{ route($link['route']) }}"
           class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                  {{ request()->routeIs($link['route']) ? 'bg-navy text-white' : 'text-navy/70 hover:bg-slate-100' }}">
            {{ $link['label'] }}
        </a>
        @endforeach
        <div class="border-t border-slate-100 mt-2 pt-2 space-y-1">
            <a href="{{ route('admin.akaun') }}"
               class="block px-4 py-2.5 rounded-lg text-sm font-medium text-navy/70 hover:bg-slate-100 transition">
                Urus Akaun
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition">
                    Log Keluar
                </button>
            </form>
        </div>
        <div class="flex items-center justify-between pt-3 mt-1 border-t border-slate-100 px-1">
            <span class="text-slate-400 text-xs">{{ now()->format('d M Y') }}</span>
            <a href="/" target="_blank" class="text-gold hover:text-navy text-xs font-medium transition">Lihat Laman →</a>
        </div>
    </div>
</nav>

<script>
function toggleAdminMenu() {
    document.getElementById('admin-mobile-menu').classList.toggle('hidden');
    document.getElementById('admin-menu-open').classList.toggle('hidden');
    document.getElementById('admin-menu-close').classList.toggle('hidden');
}

function toggleProfileMenu() {
    document.getElementById('admin-profile-menu').classList.toggle('hidden');
}

// Close profile dropdown when clicking anywhere outside it.
document.addEventListener('click', function (e) {
    var wrapper = document.getElementById('admin-profile-wrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        document.getElementById('admin-profile-menu').classList.add('hidden');
    }
});
</script>

<!-- Page content -->
<main class="flex-1 w-full py-6 sm:py-10">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        @yield('admin_content')
    </div>
</main>

<!-- Footer -->
<footer class="border-t border-slate-200 bg-white">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between gap-3">
        <p class="text-xs text-slate-400">© {{ date('Y') }} Rahmah Consultancy Services. Hak Cipta Terpelihara.</p>
        <p class="text-xs text-slate-300">Panel Pentadbir v1.0</p>
    </div>
</footer>

{{-- ── Shared themed confirm modal (admin) ───────────────────────────────────
     Replaces native confirm()/beforeunload popups with an on-brand dialog.
     Use via JS: window.rcmsConfirm({title, message, confirmText, cancelText, danger}) → Promise<bool>
     Or declaratively: <form data-confirm="msg" data-confirm-danger data-confirm-title="…" data-confirm-ok="…"> --}}
<div id="rcms-modal" class="fixed inset-0 z-[200] hidden items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="rcms-modal-title">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" data-rcms-dismiss></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div id="rcms-modal-icon" class="w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0"></div>
                <div class="flex-1 min-w-0">
                    <h3 id="rcms-modal-title" class="text-base font-bold text-slate-800 mb-1"></h3>
                    <p id="rcms-modal-message" class="text-sm text-slate-500 leading-relaxed"></p>
                </div>
            </div>
        </div>
        <div class="flex gap-3 px-6 pb-6">
            <button type="button" id="rcms-modal-cancel" class="flex-1 py-2.5 px-4 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition"></button>
            <button type="button" id="rcms-modal-confirm" class="flex-1 py-2.5 px-4 rounded-xl text-sm font-semibold text-white transition"></button>
        </div>
    </div>
</div>
<script>
(function () {
    const modal = document.getElementById('rcms-modal');
    const iconWrap = document.getElementById('rcms-modal-icon');
    const titleEl = document.getElementById('rcms-modal-title');
    const msgEl = document.getElementById('rcms-modal-message');
    const okBtn = document.getElementById('rcms-modal-confirm');
    const cancelBtn = document.getElementById('rcms-modal-cancel');
    let resolver = null;

    const ICON_DANGER = '<svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>';
    const ICON_INFO = '<svg class="w-5 h-5 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M12 17.25h.008v.008H12v-.008z"/></svg>';

    function close(result) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
        const r = resolver; resolver = null;
        if (r) r(result);
    }

    window.rcmsConfirm = function (opts) {
        opts = opts || {};
        const danger = !!opts.danger;
        titleEl.textContent = opts.title || 'Sahkan Tindakan';
        msgEl.textContent = opts.message || 'Adakah anda pasti?';
        okBtn.textContent = opts.confirmText || 'Ya';
        cancelBtn.textContent = opts.cancelText || 'Batal';
        iconWrap.className = 'w-11 h-11 rounded-full flex items-center justify-center flex-shrink-0 ' + (danger ? 'bg-red-50' : 'bg-navy/10');
        iconWrap.innerHTML = danger ? ICON_DANGER : ICON_INFO;
        okBtn.className = 'flex-1 py-2.5 px-4 rounded-xl text-sm font-semibold text-white transition ' + (danger ? 'bg-red-600 hover:bg-red-700' : 'bg-navy hover:bg-navy-dark');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        okBtn.focus();
        return new Promise(function (resolve) { resolver = resolve; });
    };

    okBtn.addEventListener('click', function () { close(true); });
    cancelBtn.addEventListener('click', function () { close(false); });
    modal.querySelectorAll('[data-rcms-dismiss]').forEach(function (el) {
        el.addEventListener('click', function () { close(false); });
    });
    document.addEventListener('keydown', function (e) {
        if (modal.classList.contains('hidden')) return;
        if (e.key === 'Escape') close(false);
        else if (e.key === 'Enter') { e.preventDefault(); close(true); }
    });

    // Declarative: any <form data-confirm="…"> is intercepted and themed.
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (!(form instanceof HTMLFormElement) || !form.hasAttribute('data-confirm') || form.dataset.rcmsConfirmed) return;
        e.preventDefault();
        window.rcmsConfirm({
            title: form.dataset.confirmTitle || 'Sahkan Tindakan',
            message: form.getAttribute('data-confirm'),
            confirmText: form.dataset.confirmOk || 'Ya, teruskan',
            cancelText: form.dataset.confirmCancel || 'Batal',
            danger: form.hasAttribute('data-confirm-danger'),
        }).then(function (ok) {
            if (ok) { form.dataset.rcmsConfirmed = '1'; form.submit(); }
        });
    }, true);
})();
</script>

<script>
/* Security warning — shown when DevTools is opened on the admin panel. */
(function () {
    var warn = function () {
        console.clear();
        console.log('%c⚠ AMARAN KESELAMATAN', 'color:#dc2626;font-size:28px;font-weight:bold;font-family:sans-serif;');
        console.log('%cRuang ini adalah untuk pembangun sahaja.\nJika seseorang meminta anda menyalin atau menaip sesuatu di sini, ini mungkin penipuan.', 'color:#374151;font-size:14px;line-height:1.6;font-family:sans-serif;');
        console.log('%cRahmah Consultancy Services — Panel Pentadbir', 'color:#6b7280;font-size:11px;font-family:sans-serif;');
    };
    warn();
    /* Re-emit on visibility change (catches open-on-tab-switch). */
    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) warn();
    });
})();
</script>
</body>
</html>
