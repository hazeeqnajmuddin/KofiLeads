<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') — Rahmah Consulting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900 font-sans antialiased min-h-screen flex flex-col">

<!-- Top Nav -->
<nav class="bg-navy sticky top-0 z-50 shadow-md">
    <div class="max-w-screen-xl mx-auto px-6 flex items-center justify-between h-14 gap-6">

        <!-- Left: Brand -->
        <div class="flex-shrink-0 flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-md bg-gold flex items-center justify-center shrink-0">
                <span class="text-navy font-black text-xs tracking-tight">RC</span>
            </div>
            <div class="flex flex-col leading-none gap-0.5">
                <span class="text-white font-bold text-sm tracking-tight leading-none">Rahmah <span class="text-gold">Consultancy</span></span>
                <span class="text-white/35 text-[9px] tracking-widest uppercase font-medium">Services</span>
            </div>
        </div>

        <!-- Center: Nav links -->
        <div class="flex items-center gap-1 flex-1 justify-center">
            <a href="{{ route('admin.dashboard') }}"
               class="px-4 py-1.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                Papan Pemuka
            </a>
            <a href="{{ route('admin.permohonan') }}"
               class="px-4 py-1.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admin.permohonan') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                Permohonan
            </a>
            <a href="{{ route('admin.laporan') }}"
               class="px-4 py-1.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admin.laporan') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                Laporan
            </a>
            <a href="{{ route('admin.landing') }}"
               class="px-4 py-1.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admin.landing') ? 'bg-white/15 text-white' : 'text-white/60 hover:text-white hover:bg-white/10' }}">
                Tetapan Laman
            </a>
        </div>

        <!-- Right: User profile + date + site link -->
        <div class="flex items-center gap-4 flex-shrink-0">
            <span class="text-white/35 text-xs hidden sm:block">{{ now()->format('d M Y') }}</span>
            <a href="/" target="_blank" class="text-gold hover:text-white text-xs font-medium transition hidden sm:block">Lihat Laman →</a>

            <!-- User profile button -->
            <div class="flex items-center gap-2.5 bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/40 active:bg-white/25 transition-all duration-150 rounded-lg px-3 py-2 cursor-pointer select-none group">
                <div class="w-7 h-7 rounded-md bg-gold flex items-center justify-center text-navy text-xs font-black shrink-0">A</div>
                <div class="flex flex-col leading-none gap-0.5">
                    <span class="text-white text-xs font-semibold tracking-tight">Pentadbir</span>
                    <span class="text-white/45 text-[10px]">Administrator</span>
                </div>
                <svg class="w-3.5 h-3.5 text-white/40 group-hover:text-white/70 transition ml-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

    </div>
</nav>

<!-- Page content -->
<main class="flex-1 w-full py-10">
    <div class="max-w-screen-xl mx-auto px-6">
        @yield('admin_content')
    </div>
</main>

<!-- Footer -->
<footer class="border-t border-slate-200 bg-white">
    <div class="max-w-screen-xl mx-auto px-6 py-4 flex items-center justify-between">
        <p class="text-xs text-slate-400">© {{ date('Y') }} Rahmah Consultancy Services. Hak Cipta Terpelihara.</p>
        <p class="text-xs text-slate-300">Panel Pentadbir v1.0</p>
    </div>
</footer>

</body>
</html>
