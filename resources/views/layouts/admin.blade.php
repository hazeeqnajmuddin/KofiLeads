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

            <!-- User profile + logout dropdown -->
            <div class="relative">
                <button onclick="toggleUserMenu()" id="user-menu-btn"
                        class="flex items-center gap-2.5 bg-slate-100 hover:bg-slate-200 border border-slate-200 hover:border-slate-300 transition-all duration-150 rounded-lg px-2 sm:px-3 py-1.5 sm:py-2 select-none group">
                    <div class="w-7 h-7 rounded-md bg-navy flex items-center justify-center text-white text-xs font-black shrink-0">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden sm:flex flex-col leading-none gap-0.5 text-left">
                        <span class="text-navy text-xs font-semibold tracking-tight">{{ Auth::user()->name ?? 'Pentadbir' }}</span>
                        <span class="text-slate-400 text-[10px]">Administrator</span>
                    </div>
                    <svg class="hidden sm:block w-3.5 h-3.5 text-slate-400 group-hover:text-navy transition ml-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Dropdown -->
                <div id="user-menu-dropdown"
                     class="hidden absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-xl shadow-lg z-50 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-100">
                        <p class="text-xs font-semibold text-slate-700 truncate">{{ Auth::user()->name ?? 'Pentadbir' }}</p>
                        <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition text-left">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
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
        <div class="flex items-center justify-between pt-3 mt-2 border-t border-slate-100 px-1">
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

function toggleUserMenu() {
    document.getElementById('user-menu-dropdown').classList.toggle('hidden');
}

document.addEventListener('click', function (e) {
    const btn      = document.getElementById('user-menu-btn');
    const dropdown = document.getElementById('user-menu-dropdown');
    if (btn && dropdown && !btn.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
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

</body>
</html>
