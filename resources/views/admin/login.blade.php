<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Log Masuk — Panel Admin RCS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.jpeg') }}">
    @PwaHead
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center px-4"
      style="background: linear-gradient(135deg, #0F1A45 0%, #1B2B6B 60%, #0F1A45 100%);">

    {{-- Gold top border --}}
    <div class="fixed top-0 left-0 right-0 h-1 z-10"
         style="background: linear-gradient(90deg, #A8882E, #FFE87C, #C9A840, #FFE87C, #A8882E);"></div>

    {{-- Background decorative blobs --}}
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full opacity-10"
             style="background: radial-gradient(circle, #C9A840, transparent);"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full opacity-10"
             style="background: radial-gradient(circle, #C9A840, transparent);"></div>
    </div>

    {{-- Card --}}
    <div class="relative w-full max-w-md">

        {{-- Logo badge (snug, floating above the card) --}}
        <div class="flex justify-center mb-6">
            <div class="bg-white rounded-xl px-6 py-3 shadow-xl ring-1 ring-white/10">
                <img src="{{ asset('images/logo4.png') }}" alt="Rahmah Consultancy Services"
                     class="h-24 w-auto object-contain">
            </div>
        </div>

        {{-- Heading --}}
        <div class="text-center mb-6">
            <h1 class="text-white text-2xl font-bold tracking-tight">Panel Admin</h1>
            <p class="text-slate-400 text-sm mt-1">Log masuk untuk mengurus permohonan</p>
        </div>

        {{-- Login form card --}}
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">

            {{-- Card top accent --}}
            <div class="h-1" style="background: linear-gradient(90deg, #A8882E, #FFE87C, #C9A840);"></div>

            <div class="px-8 py-8">

                {{-- Error alert --}}
                @if ($errors->any())
                <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm">{{ $errors->first() }}</p>
                </div>
                @endif

                {{-- Session status (e.g. after logout) --}}
                @if (session('status'))
                <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-sm">{{ session('status') }}</p>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-600 mb-1.5">
                            Alamat Emel
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                   required autofocus autocomplete="username"
                                   placeholder="admin@rahmahconsultancy.com"
                                   class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm transition
                                          {{ $errors->has('email') ? 'border-red-300 bg-red-50 focus:ring-red-200 focus:border-red-400' : 'border-slate-200 bg-slate-50 focus:ring-navy/20 focus:border-navy' }}
                                          focus:outline-none focus:ring-2">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-semibold text-slate-600 mb-1.5">
                            Kata Laluan
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input id="password" type="password" name="password"
                                   required autocomplete="current-password"
                                   placeholder="••••••••"
                                   class="w-full pl-10 pr-11 py-2.5 border rounded-xl text-sm transition
                                          {{ $errors->has('email') ? 'border-red-300 bg-red-50 focus:ring-red-200 focus:border-red-400' : 'border-slate-200 bg-slate-50 focus:ring-navy/20 focus:border-navy' }}
                                          focus:outline-none focus:ring-2">
                            {{-- Show/hide toggle --}}
                            <button type="button" onclick="togglePassword()"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition">
                                <svg id="eye-show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-hide" class="w-4 h-4 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" id="remember"
                                   class="w-4 h-4 accent-navy rounded">
                            <span class="text-xs text-slate-500 group-hover:text-slate-700 transition select-none">Ingat saya</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="btn-gold-metallic w-full font-bold py-3 px-4 text-sm tracking-wide shadow-lg mt-1">
                        Log Masuk
                    </button>

                </form>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-6 space-y-2">
            <a href="/" class="text-slate-400 hover:text-white text-xs transition flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Laman Utama
            </a>
            <p class="text-slate-600 text-[11px]">© {{ date('Y') }} Rahmah Consultancy Services</p>
        </div>

    </div>

    <script>
    function togglePassword() {
        const input = document.getElementById('password');
        const show  = document.getElementById('eye-show');
        const hide  = document.getElementById('eye-hide');
        if (input.type === 'password') {
            input.type = 'text';
            show.classList.add('hidden');
            hide.classList.remove('hidden');
        } else {
            input.type = 'password';
            show.classList.remove('hidden');
            hide.classList.add('hidden');
        }
    }
    </script>

    @RegisterServiceWorkerScript
</body>
</html>
