@extends('layouts.admin')

@section('title', 'Urus Akaun')

@section('admin_content')

<div class="max-w-xl mx-auto space-y-6">

    {{-- Page heading --}}
    <div>
        <h1 class="text-xl font-bold text-slate-800">Urus Akaun</h1>
        <p class="text-sm text-slate-500 mt-0.5">Kemaskini maklumat log masuk anda.</p>
    </div>

    {{-- Account info (read-only) --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-navy flex items-center justify-center text-white text-base font-black">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-semibold text-slate-800">{{ $user->name }}</p>
                <p class="text-xs text-slate-400">{{ $user->email }}</p>
            </div>
        </div>
        <div class="px-6 py-4 grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-xs font-medium text-slate-400 mb-0.5">Nama</p>
                <p class="text-slate-700 font-medium">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 mb-0.5">Emel</p>
                <p class="text-slate-700 font-medium">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 mb-0.5">Peranan</p>
                <p class="text-slate-700 font-medium">Administrator</p>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 mb-0.5">Ahli Sejak</p>
                <p class="text-slate-700 font-medium">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Change password form --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h2 class="text-sm font-semibold text-slate-800">Tukar Kata Laluan</h2>
            <p class="text-xs text-slate-400 mt-0.5">Kata laluan baharu mestilah sekurang-kurangnya 8 aksara.</p>
        </div>

        <form method="POST" action="{{ route('admin.akaun.update') }}" class="px-6 py-5 space-y-4">
            @csrf

            {{-- Current password --}}
            <div>
                <label for="current_password" class="block text-xs font-semibold text-slate-600 mb-1.5">
                    Kata Laluan Semasa
                </label>
                <input id="current_password" type="password" name="current_password"
                       required autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full px-3.5 py-2.5 border rounded-xl text-sm transition
                              {{ $errors->has('current_password') ? 'border-red-300 bg-red-50 focus:ring-red-200 focus:border-red-400' : 'border-slate-200 bg-slate-50 focus:ring-navy/20 focus:border-navy' }}
                              focus:outline-none focus:ring-2">
                @error('current_password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- New password --}}
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-600 mb-1.5">
                    Kata Laluan Baharu
                </label>
                <input id="password" type="password" name="password"
                       required autocomplete="new-password"
                       placeholder="••••••••"
                       class="w-full px-3.5 py-2.5 border rounded-xl text-sm transition
                              {{ $errors->has('password') ? 'border-red-300 bg-red-50 focus:ring-red-200 focus:border-red-400' : 'border-slate-200 bg-slate-50 focus:ring-navy/20 focus:border-navy' }}
                              focus:outline-none focus:ring-2">
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm new password --}}
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-600 mb-1.5">
                    Sahkan Kata Laluan Baharu
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       required autocomplete="new-password"
                       placeholder="••••••••"
                       class="w-full px-3.5 py-2.5 border rounded-xl text-sm transition border-slate-200 bg-slate-50 focus:ring-navy/20 focus:border-navy focus:outline-none focus:ring-2">
            </div>

            <div class="pt-1">
                <button type="submit"
                        class="btn-gold-metallic px-6 py-2.5 text-sm font-semibold shadow-sm">
                    Kemaskini Kata Laluan
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
