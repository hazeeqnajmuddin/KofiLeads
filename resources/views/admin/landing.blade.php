@extends('layouts.admin')

@section('title', 'Tetapan Laman')
@section('page_title', 'Tetapan Laman')
@section('page_subtitle', 'Kemaskini maklumat hubungan dan kandungan laman utama')

@section('admin_content')

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

    <!-- WhatsApp Number -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800 text-sm">Nombor WhatsApp</h3>
            <p class="text-xs text-slate-400 mt-0.5">Nombor yang menerima semua permohonan dari laman</p>
        </div>
        <div class="p-6">
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nombor Telefon (dengan kod negara)</label>
                    <input type="tel" name="whatsapp_number" value="+60"
                           placeholder="+60123456789"
                           class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                    <p class="text-xs text-slate-400 mt-1.5">Contoh: +60123456789</p>
                </div>
                <button type="submit"
                        class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    Simpan Nombor
                </button>
            </form>
        </div>
    </div>

    <!-- Contact Details -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800 text-sm">Maklumat Hubungan</h3>
            <p class="text-xs text-slate-400 mt-0.5">Dipaparkan di bahagian footer laman</p>
        </div>
        <div class="p-6">
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat Emel</label>
                    <input type="email" name="contact_email"
                           placeholder="info@rahmahconsultancy.com"
                           class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Facebook URL</label>
                    <input type="url" name="facebook_url"
                           placeholder="https://facebook.com/rahmahconsultancy"
                           class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">TikTok URL</label>
                    <input type="url" name="tiktok_url"
                           placeholder="https://tiktok.com/@rahmahconsultancy"
                           class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Instagram URL</label>
                    <input type="url" name="instagram_url"
                           placeholder="https://instagram.com/rahmahconsultancy"
                           class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                </div>
                <button type="submit"
                        class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    Simpan Maklumat
                </button>
            </form>
        </div>
    </div>

    <!-- Hero Content -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden lg:col-span-2">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800 text-sm">Kandungan Hero</h3>
            <p class="text-xs text-slate-400 mt-0.5">Tajuk dan teks utama di bahagian atas laman</p>
        </div>
        <div class="p-6">
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tajuk Utama</label>
                        <input type="text" name="hero_title" value="Semak Kelayakan Anda"
                               class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Teks Butang (CTA)</label>
                        <input type="text" name="hero_cta" value="Semak Kelayakan Sekarang"
                               class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Sub-tajuk</label>
                    <textarea name="hero_subtitle" rows="2"
                              class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">Rahmah Consultancy Services menyediakan penyelesaian kewangan yang inovatif. Sertai lebih 10,000 pelanggan yang telah mempercayai kami.</textarea>
                </div>
                <button type="submit" class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    Simpan Kandungan
                </button>
            </form>
        </div>
    </div>

    <!-- Eligibility Criteria -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800 text-sm">Kriteria Kelayakan</h3>
            <p class="text-xs text-slate-400 mt-0.5">Gaji asas minimum bagi semakan awal (dipaparkan di FAQ)</p>
        </div>
        <div class="p-6">
            <form action="#" method="POST" class="space-y-4">
                @csrf
                @php
                $criteria = [
                    ['label' => 'Kerajaan',              'name' => 'min_gaji_kerajaan', 'val' => '1500'],
                    ['label' => 'GLC / Badan Berkanun',  'name' => 'min_gaji_glc',      'val' => '2500'],
                    ['label' => 'Swasta',                'name' => 'min_gaji_swasta',   'val' => '3000'],
                ];
                @endphp
                @foreach($criteria as $c)
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">{{ $c['label'] }} <span class="text-slate-400 font-normal">(RM)</span></label>
                    <input type="number" name="{{ $c['name'] }}" value="{{ $c['val'] }}" min="0"
                           class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                </div>
                @endforeach
                <button type="submit" class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    Simpan Kriteria
                </button>
            </form>
        </div>
    </div>

    <!-- Operating Hours -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800 text-sm">Waktu Operasi</h3>
            <p class="text-xs text-slate-400 mt-0.5">Masa khidmat pelanggan tersedia</p>
        </div>
        <div class="p-6">
            <form action="#" method="POST" class="space-y-3">
                @csrf
                @php
                $days = [
                    ['label' => 'Isnin – Jumaat', 'open' => '09:00', 'close' => '18:00', 'closed' => false],
                    ['label' => 'Sabtu',           'open' => '10:00', 'close' => '14:00', 'closed' => false],
                    ['label' => 'Ahad & Cuti Umum','open' => '',      'close' => '',      'closed' => true],
                ];
                @endphp
                @foreach($days as $i => $day)
                <div class="flex items-center gap-3">
                    <span class="text-xs font-medium text-slate-600 w-32 flex-shrink-0">{{ $day['label'] }}</span>
                    @if($day['closed'])
                        <span class="text-xs text-red-500 font-medium">Tutup</span>
                    @else
                        <input type="time" name="hours[{{ $i }}][open]" value="{{ $day['open'] }}"
                               class="text-sm border border-slate-200 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                        <span class="text-slate-400 text-xs">hingga</span>
                        <input type="time" name="hours[{{ $i }}][close]" value="{{ $day['close'] }}"
                               class="text-sm border border-slate-200 rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                    @endif
                </div>
                @endforeach
                <button type="submit" class="mt-2 bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    Simpan Waktu
                </button>
            </form>
        </div>
    </div>

    <!-- Office Address -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden lg:col-span-2">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800 text-sm">Alamat Pejabat</h3>
            <p class="text-xs text-slate-400 mt-0.5">Lokasi dan pautan Google Maps untuk footer laman</p>
        </div>
        <div class="p-6">
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat Penuh</label>
                    <textarea name="office_address" rows="2" placeholder="No. 12, Jalan Contoh, 40000 Shah Alam, Selangor"
                              class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Pautan Google Maps</label>
                    <input type="url" name="maps_url" placeholder="https://maps.google.com/..."
                           class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                </div>
                <button type="submit" class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    Simpan Alamat
                </button>
            </form>
        </div>
    </div>

    <!-- Video Upload -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden lg:col-span-2">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800 text-sm">Video Iklan</h3>
            <p class="text-xs text-slate-400 mt-0.5">Muat naik video promosi untuk dipaparkan di laman utama</p>
        </div>
        <div class="p-6">
            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center hover:border-navy/30 transition cursor-pointer">
                    <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-slate-500 mb-1">Seret fail video ke sini atau</p>
                    <label class="inline-block cursor-pointer text-navy hover:text-gold font-medium text-sm transition">
                        pilih fail
                        <input type="file" name="video_iklan" accept="video/*" class="hidden">
                    </label>
                    <p class="text-xs text-slate-400 mt-2">MP4, MOV — Saiz maksimum 100MB</p>
                </div>
                <button type="submit"
                        class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                    Muat Naik Video
                </button>
            </form>
        </div>
    </div>

</div>

@endsection
