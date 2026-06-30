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
<nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-screen-xl mx-auto px-6 flex items-center justify-between h-16 gap-6">

        <!-- Left: Logo -->
        <div class="flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Rahmah Consultancy Services" class="h-16 w-auto">
            </a>
        </div>

        <!-- Center: Nav links -->
        <div class="flex items-center gap-1 flex-1 justify-center">
            <a href="{{ route('admin.dashboard') }}"
               class="px-4 py-1.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admin.dashboard') ? 'bg-navy text-white' : 'text-navy/60 hover:text-navy hover:bg-slate-100' }}">
                Papan Pemuka
            </a>
            <a href="{{ route('admin.permohonan') }}"
               class="px-4 py-1.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admin.permohonan') ? 'bg-navy text-white' : 'text-navy/60 hover:text-navy hover:bg-slate-100' }}">
                Permohonan
            </a>
            <a href="{{ route('admin.laporan') }}"
               class="px-4 py-1.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admin.laporan') ? 'bg-navy text-white' : 'text-navy/60 hover:text-navy hover:bg-slate-100' }}">
                Laporan
            </a>
            <a href="{{ route('admin.landing') }}"
               class="px-4 py-1.5 rounded-lg text-sm font-medium transition
                      {{ request()->routeIs('admin.landing') ? 'bg-navy text-white' : 'text-navy/60 hover:text-navy hover:bg-slate-100' }}">
                Tetapan Laman
            </a>
        </div>

        <!-- Right: User profile + date + site link -->
        <div class="flex items-center gap-4 flex-shrink-0">
            <span class="text-slate-400 text-xs hidden sm:block">{{ now()->format('d M Y') }}</span>
            <a href="/" target="_blank" class="text-gold hover:text-navy text-xs font-medium transition hidden sm:block">Lihat Laman →</a>

            <!-- User profile button -->
            <div class="flex items-center gap-2.5 bg-slate-100 hover:bg-slate-200 border border-slate-200 hover:border-slate-300 active:bg-slate-200 transition-all duration-150 rounded-lg px-3 py-2 cursor-pointer select-none group">
                <div class="w-7 h-7 rounded-md bg-navy flex items-center justify-center text-white text-xs font-black shrink-0">A</div>
                <div class="flex flex-col leading-none gap-0.5">
                    <span class="text-navy text-xs font-semibold tracking-tight">Pentadbir</span>
                    <span class="text-slate-400 text-[10px]">Administrator</span>
                </div>
                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-navy transition ml-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
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
