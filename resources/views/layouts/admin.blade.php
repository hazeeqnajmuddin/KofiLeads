<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin - Rahmah Consulting')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Modernized Top Navigation Menu (Glassmorphism & Fixed Z-Index Bug) -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Brand Identity -->
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-xl bg-navy flex items-center justify-center text-gold font-black tracking-tighter text-sm shadow-sm">
                        RC
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-slate-900 tracking-tight leading-none">Rahmah Consulting</span>
                        <span class="text-[10px] text-slate-400 font-medium tracking-wider uppercase mt-0.5">Sistem Pentadbir</span>
                    </div>
                </div>

                <!-- Right Side Info -->
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex flex-col text-right">
                        <span class="text-xs font-semibold text-slate-800 leading-none">Pengurusan Utama</span>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center font-bold text-xs shadow-xs">
                        ADM
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <!-- Main Dynamic Content Wrapper -->
    <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        @yield('admin_content')
    </main>

</body>
</html>