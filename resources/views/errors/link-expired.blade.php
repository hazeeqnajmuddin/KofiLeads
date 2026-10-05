@extends('layouts.main')

@section('title', 'Pautan Tamat Tempoh')

@section('content')
<section class="min-h-[70vh] flex items-center justify-center px-4 py-20">
    <div class="max-w-md w-full text-center bg-white rounded-2xl border border-slate-100 shadow-sm p-10">
        <div class="w-14 h-14 mx-auto mb-5 rounded-full bg-rose-50 flex items-center justify-center">
            <svg class="w-7 h-7 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"/>
            </svg>
        </div>
        <h1 class="text-xl font-bold text-navy mb-2">Pautan Tamat Tempoh</h1>
        <p class="text-sm text-slate-500 leading-relaxed mb-6">
            Pautan dokumen ini telah tamat tempoh atau tidak sah. Sila hubungi pihak kami untuk mendapatkan pautan yang baharu.
        </p>
        <a href="{{ url('/') }}" class="inline-block bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-6 py-3 rounded-xl transition">
            Kembali ke Laman Utama
        </a>
    </div>
</section>
@endsection
