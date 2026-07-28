@extends('layouts.admin')

@section('title', 'Tetapan Laman')
@section('page_title', 'Tetapan Laman')
@section('page_subtitle', 'Kemaskini maklumat hubungan dan kandungan laman utama')

@section('admin_content')

@php
// Reusable section-header renderer kept inline to avoid a new partial.
@endphp

{{-- ═══════════ SECTION: HERO ═══════════ --}}
<section class="mb-8">
    <div class="mb-4">
        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
            <span class="w-1.5 h-4 rounded-full bg-gold flex-shrink-0"></span>
            Bahagian Hero
        </h2>
        <p class="text-xs text-slate-400 mt-1 ml-3.5">Bahagian paling atas laman — tajuk utama dan video promosi</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- Hero Content -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Kandungan Hero</h3>
                <p class="text-xs text-slate-400 mt-0.5">Tajuk dan teks utama di bahagian atas laman</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.landing.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tajuk Utama</label>
                            <input type="text" name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? 'Semak Kelayakan Anda') }}"
                                   class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Teks Butang (CTA)</label>
                            <input type="text" name="hero_cta" value="{{ old('hero_cta', $settings['hero_cta'] ?? 'Buat Semakan Awal Sekarang') }}"
                                   class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Sub-tajuk</label>
                        <textarea name="hero_subtitle" rows="2"
                                  class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                    </div>
                    <button type="submit" class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Simpan Kandungan
                    </button>
                </form>
            </div>
        </div>

        <!-- Video Upload -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Video Iklan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Muat naik video promosi untuk dipaparkan di laman utama</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.landing.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @if(!empty($settings['video_iklan']))
                    <p class="text-xs text-slate-500 mb-2">Video semasa: <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($settings['video_iklan']) }}" target="_blank" class="text-navy font-medium underline">lihat</a></p>
                    @endif
                    <div id="video-dropzone" class="border-2 border-dashed border-slate-200 rounded-xl p-8 text-center hover:border-navy/30 transition cursor-pointer">
                        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-slate-500 mb-1">Seret fail video ke sini atau</p>
                        <label class="inline-block cursor-pointer text-navy hover:text-gold font-medium text-sm transition">
                            pilih fail
                            <input type="file" id="video_iklan" name="video_iklan" accept="video/*" class="hidden">
                        </label>
                        {{-- Selected file name appears here --}}
                        <p id="video-filename" class="hidden text-sm font-medium text-navy mt-3 break-all"></p>
                        <p id="video-size-warning" class="hidden text-xs text-rose-500 font-semibold mt-2"></p>
                        <p class="text-xs text-slate-400 mt-2">MP4, MOV — Saiz maksimum 100MB</p>
                    </div>
                    <script>
                    (function () {
                        var MAX = 100 * 1024 * 1024; // 100 MB (matches server rule max:102400)
                        var input = document.getElementById('video_iklan');
                        var zone  = document.getElementById('video-dropzone');
                        var name  = document.getElementById('video-filename');
                        var warn  = document.getElementById('video-size-warning');

                        function show() {
                            var file = input.files && input.files[0];
                            if (!file) { name.classList.add('hidden'); warn.classList.add('hidden'); return; }
                            name.textContent = '📹 ' + file.name + ' (' + (file.size / 1048576).toFixed(1) + ' MB)';
                            name.classList.remove('hidden');
                            if (file.size > MAX) {
                                warn.textContent = 'Fail melebihi 100MB. Sila pilih fail yang lebih kecil.';
                                warn.classList.remove('hidden');
                                input.value = '';
                                name.classList.add('hidden');
                            } else {
                                warn.classList.add('hidden');
                            }
                        }

                        input.addEventListener('change', show);

                        // Wire the drag-and-drop the decorative zone always implied.
                        ['dragover', 'dragenter'].forEach(function (ev) {
                            zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.add('border-navy'); });
                        });
                        ['dragleave', 'drop'].forEach(function (ev) {
                            zone.addEventListener(ev, function (e) { e.preventDefault(); zone.classList.remove('border-navy'); });
                        });
                        zone.addEventListener('drop', function (e) {
                            if (e.dataTransfer && e.dataTransfer.files.length) {
                                input.files = e.dataTransfer.files;
                                show();
                            }
                        });
                        zone.addEventListener('click', function (e) {
                            if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'LABEL' && e.target.tagName !== 'A') input.click();
                        });
                    })();
                    </script>
                    <button type="submit"
                            class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Muat Naik Video
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════ SECTION: PROFIL PEMILIK ═══════════ --}}
<section class="mb-8">
    <div class="mb-4">
        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
            <span class="w-1.5 h-4 rounded-full bg-gold flex-shrink-0"></span>
            Profil Pemilik
        </h2>
        <p class="text-xs text-slate-400 mt-1 ml-3.5">Biodata yang dipaparkan di bawah bahagian Hero</p>
    </div>
    <div class="grid grid-cols-1 gap-5">

        <!-- Biodata Content -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Kandungan Biodata</h3>
                <p class="text-xs text-slate-400 mt-0.5">Nama, jawatan, info, statistik dan pautan media sosial pemilik</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.landing.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- 1. Image Upload Field -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Gambar Profil</label>
                        @if(!empty($settings['bio_image']))
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($settings['bio_image']) }}" alt="Gambar profil semasa" class="w-16 h-16 rounded-lg object-cover mb-2 border border-slate-200">
                        @endif
                        <input type="file" name="bio_image" accept="image/*"
                            class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 bg-white focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                        <p class="text-xs text-slate-400 mt-1">Muat naik gambar beresolusi tinggi (format .jpg, .png). Biar kosong untuk kekalkan gambar semasa.</p>
                    </div>

                    @php
                    // Biodata Info (repopulated from saved settings)
                    $criteria = [
                        ['label' => 'Jawatan', 'name' => 'bio_jawatan', 'val' => $settings['bio_jawatan'] ?? 'Pengarah Urusan'],
                        ['label' => 'Nama',    'name' => 'bio_nama',    'val' => $settings['bio_nama'] ?? 'Khairul Amri Chamili'],
                        ['label' => 'Info',    'name' => 'bio_info',    'val' => $settings['bio_info'] ?? ''],
                    ];

                    // 3 Cards Data Reference
                    $stats = [
                        ['title' => 'Kad 1', 'val_name' => 'stat_1_val', 'val_data' => $settings['stat_1_val'] ?? '8+',   'label_name' => 'stat_1_label', 'label_data' => $settings['stat_1_label'] ?? 'Tahun Pengalaman'],
                        ['title' => 'Kad 2', 'val_name' => 'stat_2_val', 'val_data' => $settings['stat_2_val'] ?? '10k+', 'label_name' => 'stat_2_label', 'label_data' => $settings['stat_2_label'] ?? 'Pelanggan Dibantu'],
                        ['title' => 'Kad 3', 'val_name' => 'stat_3_val', 'val_data' => $settings['stat_3_val'] ?? '91%',  'label_name' => 'stat_3_label', 'label_data' => $settings['stat_3_label'] ?? 'Kadar Kelulusan'],
                    ];

                    // Social Media Links Reference
                    $socials = [
                        ['label' => 'Facebook URL',  'name' => 'social_facebook',  'val' => $settings['social_facebook'] ?? '',  'placeholder' => 'https://facebook.com/...'],
                        ['label' => 'Instagram URL', 'name' => 'social_instagram', 'val' => $settings['social_instagram'] ?? '', 'placeholder' => 'https://instagram.com/...'],
                        ['label' => 'TikTok URL',    'name' => 'social_tiktok',    'val' => $settings['social_tiktok'] ?? '',   'placeholder' => 'https://tiktok.com/...'],
                    ];
                    @endphp

                    <div class="space-y-4">
                        @foreach($criteria as $c)
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">{{ $c['label'] }}</label>

                            @if($c['name'] == 'bio_info')
                                <textarea name="{{ $c['name'] }}" rows="6"
                                        class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">{{ $c['val'] }}</textarea>
                            @else
                                <input type="text" name="{{ $c['name'] }}" value="{{ $c['val'] }}"
                                    class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <hr class="border-slate-100">

                    <!-- 2. The 3 Editable Cards Below -->
                    <div>
                        <h4 class="font-semibold text-slate-800 text-sm mb-3">Statistik (3 Kad Bawah)</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($stats as $stat)
                            <div class="p-4 border border-slate-100 bg-slate-50 rounded-lg space-y-3">
                                <h5 class="text-xs font-bold text-slate-700 uppercase">{{ $stat['title'] }}</h5>

                                <!-- Card Value -->
                                <div>
                                    <label class="block text-xs text-slate-500 mb-1">Nilai Teks (Kuning)</label>
                                    <input type="text" name="{{ $stat['val_name'] }}" value="{{ $stat['val_data'] }}"
                                        class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                                </div>

                                <!-- Card Label -->
                                <div>
                                    <label class="block text-xs text-slate-500 mb-1">Label Bawah</label>
                                    <input type="text" name="{{ $stat['label_name'] }}" value="{{ $stat['label_data'] }}"
                                        class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <!-- 3. Social Media Links Section -->
                    <div>
                        <h4 class="font-semibold text-slate-800 text-sm mb-3">Pautan Media Sosial</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($socials as $social)
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">{{ $social['label'] }}</label>
                                <input type="url" name="{{ $social['name'] }}" value="{{ $social['val'] }}" placeholder="{{ $social['placeholder'] }}"
                                    class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition w-fit">
                            Simpan Biodata
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════ SECTION: SERVIS ═══════════ --}}
<section class="mb-8">
    <div class="mb-4">
        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
            <span class="w-1.5 h-4 rounded-full bg-gold flex-shrink-0"></span>
            Servis
        </h2>
        <p class="text-xs text-slate-400 mt-1 ml-3.5">Tiga perkhidmatan yang dipaparkan di laman utama</p>
    </div>
    <div class="grid grid-cols-1 gap-5">

        <!-- Services Content -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Servis Kami</h3>
                <p class="text-xs text-slate-400 mt-0.5">Kemaskini maklumat perkhidmatan yang dipaparkan di halaman utama</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.landing.update') }}" method="POST" class="space-y-6">
                    @csrf

                    @php
                    $services = [
                        ['title' => 'Servis 1', 'title_name' => 'service_1_title', 'title_val' => $settings['service_1_title'] ?? 'Perancangan Kewangan', 'desc_name' => 'service_1_desc', 'desc_val' => $settings['service_1_desc'] ?? ''],
                        ['title' => 'Servis 2', 'title_name' => 'service_2_title', 'title_val' => $settings['service_2_title'] ?? 'Semakan Kelayakan Pinjaman', 'desc_name' => 'service_2_desc', 'desc_val' => $settings['service_2_desc'] ?? ''],
                        ['title' => 'Servis 3', 'title_name' => 'service_3_title', 'title_val' => $settings['service_3_title'] ?? 'Pengurusan & Penyatuan Hutang', 'desc_name' => 'service_3_desc', 'desc_val' => $settings['service_3_desc'] ?? ''],
                    ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($services as $s)
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-100 space-y-4">
                            <h4 class="text-sm font-bold text-slate-700 border-b border-slate-200 pb-2">{{ $s['title'] }}</h4>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tajuk Servis</label>
                                <input type="text" name="{{ $s['title_name'] }}" value="{{ $s['title_val'] }}"
                                       class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Penerangan</label>
                                <textarea name="{{ $s['desc_name'] }}" rows="3"
                                          placeholder="Masukkan penerangan servis..."
                                          class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">{{ $s['desc_val'] }}</textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button type="submit"
                            class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Simpan Maklumat
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════ SECTION: KELAYAKAN ═══════════ --}}
<section class="mb-8">
    <div class="mb-4">
        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
            <span class="w-1.5 h-4 rounded-full bg-gold flex-shrink-0"></span>
            Kelayakan
        </h2>
        <p class="text-xs text-slate-400 mt-1 ml-3.5">Gaji asas minimum bagi semakan awal (dipaparkan di FAQ)</p>
    </div>
    <div class="grid grid-cols-1 gap-5">

        <!-- Eligibility Criteria -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Kriteria Kelayakan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Gaji asas minimum bagi semakan awal</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.landing.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @php
                    $eligibility = [
                        ['label' => 'Kerajaan',              'name' => 'min_gaji_kerajaan', 'val' => $settings['min_gaji_kerajaan'] ?? '1500'],
                        ['label' => 'GLC / Badan Berkanun',  'name' => 'min_gaji_glc',      'val' => $settings['min_gaji_glc'] ?? '2500'],
                        ['label' => 'Swasta',                'name' => 'min_gaji_swasta',   'val' => $settings['min_gaji_swasta'] ?? '3000'],
                    ];
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($eligibility as $c)
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">{{ $c['label'] }} <span class="text-slate-400 font-normal">(RM)</span></label>
                            <input type="number" name="{{ $c['name'] }}" value="{{ $c['val'] }}" min="0"
                                   class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                        </div>
                        @endforeach
                    </div>
                    <button type="submit" class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Simpan Kriteria
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════ SECTION: HUBUNGAN & FOOTER ═══════════ --}}
<section class="mb-8">
    <div class="mb-4">
        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
            <span class="w-1.5 h-4 rounded-full bg-gold flex-shrink-0"></span>
            Hubungan &amp; Footer
        </h2>
        <p class="text-xs text-slate-400 mt-1 ml-3.5">Maklumat hubungan yang dipaparkan di bahagian footer laman</p>
    </div>
    <div class="grid grid-cols-1 gap-5">

        <!-- Contact Details -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Maklumat Hubungan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Emel dan pautan media sosial di footer</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.landing.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat Emel</label>
                            <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                                   placeholder="info@rahmahconsultancy.com"
                                   class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Facebook URL</label>
                            <input type="url" name="facebook_url" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}"
                                   placeholder="https://facebook.com/rahmahconsultancy"
                                   class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">TikTok URL</label>
                            <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $settings['tiktok_url'] ?? '') }}"
                                   placeholder="https://tiktok.com/@rahmahconsultancy"
                                   class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Instagram URL</label>
                            <input type="url" name="instagram_url" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}"
                                   placeholder="https://instagram.com/rahmahconsultancy"
                                   class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                        </div>
                    </div>
                    <p class="text-xs text-slate-400">Nombor WhatsApp footer diuruskan di bahagian <span class="font-medium text-slate-500">Integrasi WhatsApp</span> di bawah.</p>
                    <button type="submit"
                            class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Simpan Maklumat
                    </button>
                </form>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════ SECTION: BORANG SEMAKAN ═══════════ --}}
<section class="mb-8">
    <div class="mb-4">
        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
            <span class="w-1.5 h-4 rounded-full bg-gold flex-shrink-0"></span>
            Borang Semakan
        </h2>
        <p class="text-xs text-slate-400 mt-1 ml-3.5">Tetapan berkaitan borang lead — platform media sosial dan kod rujukan live</p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- Social platform options -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Platform Media Sosial</h3>
                <p class="text-xs text-slate-400 mt-0.5">Pilihan platform di borang ("Di mana anda mengetahui tentang kami?"). Pisahkan dengan koma.</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.landing.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Senarai Platform</label>
                        <input type="text" name="social_platforms" value="{{ old('social_platforms', $settings['social_platforms'] ?? 'Facebook,TikTok,Instagram') }}"
                               placeholder="Facebook,TikTok,Instagram"
                               class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                        <p class="text-xs text-slate-400 mt-1.5">"Lain-lain" sentiasa ditambah secara automatik di borang.</p>
                    </div>
                    <button type="submit" class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Simpan Platform
                    </button>
                </form>
            </div>
        </div>

        <!-- Reference Code manager (Kod Rujukan) -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Kod Rujukan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Jana kod untuk setiap sesi live. Kod aktif dipaparkan kepada pemohon untuk ditaip di borang.</p>
            </div>
            <div class="p-6 space-y-4">
                <form action="{{ route('admin.kod-rujukan.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Live Host / Sesi</label>
                        <input type="text" name="host_name" value="{{ old('host_name') }}" placeholder="Contoh: Live TikTok 21 Julai"
                               class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition" required>
                        @error('host_name')<p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kod <span class="text-slate-400 font-normal">(kosongkan untuk jana automatik)</span></label>
                        <div class="flex gap-2">
                            <input type="text" id="kod_rujukan_input" name="code" value="{{ old('code') }}" placeholder="Contoh: {{ $nextRefCode }}" maxlength="50"
                                   class="flex-1 text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition">
                            <button type="button" onclick="document.getElementById('kod_rujukan_input').value='{{ $nextRefCode }}'"
                                    class="text-xs font-medium text-navy border border-slate-200 rounded-lg px-3 hover:bg-slate-50 transition whitespace-nowrap">Jana</button>
                        </div>
                        @error('code')<p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Jana &amp; Aktifkan
                    </button>
                </form>

                @if($referenceCodes->isNotEmpty())
                <div class="border-t border-slate-100 pt-4 space-y-2">
                    @foreach($referenceCodes as $rc)
                    <div class="flex items-center justify-between gap-3 text-sm py-1.5">
                        <div class="min-w-0">
                            <span class="font-mono font-semibold text-slate-700">{{ $rc->code }}</span>
                            <span class="text-slate-400 text-xs ml-2 truncate">{{ $rc->host_name }}</span>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            @if($rc->is_active)
                            <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">AKTIF</span>
                            <form action="{{ route('admin.kod-rujukan.activate', $rc) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-[11px] font-medium text-slate-500 hover:underline">Nyahaktif</button>
                            </form>
                            @else
                            <form action="{{ route('admin.kod-rujukan.activate', $rc) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-[11px] font-medium text-navy hover:underline">Aktifkan</button>
                            </form>
                            @endif
                            <form action="{{ route('admin.kod-rujukan.destroy', $rc) }}" method="POST"
                                  data-confirm="Padam kod {{ $rc->code }}?" data-confirm-title="Padam Kod" data-confirm-ok="Ya, padam" data-confirm-danger>
                                @csrf @method('DELETE')
                                <button type="submit" class="text-[11px] font-medium text-rose-500 hover:underline">Padam</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

    </div>
</section>

{{-- ═══════════ SECTION: INTEGRASI WHATSAPP ═══════════ --}}
<section class="mb-8">
    <div class="mb-4">
        <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
            <span class="w-1.5 h-4 rounded-full bg-gold flex-shrink-0"></span>
            Integrasi WhatsApp
        </h2>
        <p class="text-xs text-slate-400 mt-1 ml-3.5">Nombor penerima dan mesej pra-isi yang dibawa ke WhatsApp selepas borang dihantar</p>
    </div>
    <div class="grid grid-cols-1 gap-5">

        <!-- WhatsApp Number -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Nombor WhatsApp</h3>
                <p class="text-xs text-slate-400 mt-0.5">Nombor yang menerima semua permohonan dari laman (juga dipaparkan di footer)</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.landing.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nombor Telefon (dengan kod negara)</label>
                        <input type="tel" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '+60') }}"
                               placeholder="+60123456789"
                               pattern="^\+60\d{8,10}$"
                               required
                               class="w-full text-sm border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition {{ $errors->has('whatsapp_number') ? 'border-red-400' : '' }}">
                        @error('whatsapp_number')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-slate-400 mt-1.5">Contoh: +60123456789 (mesti dengan kod negara, bukan mula dengan 0).</p>
                    </div>
                    <button type="submit"
                            class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Simpan Nombor
                    </button>
                </form>
            </div>
        </div>

        <!-- WhatsApp Message Template -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800 text-sm">Mesej WhatsApp</h3>
                <p class="text-xs text-slate-400 mt-0.5">Mesej yang dibawa ke WhatsApp selepas pemohon menghantar borang. Seret atau klik pemegang tempat untuk memasukkannya.</p>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.landing.update') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Draggable placeholder chips (drop into the textarea, or click to insert at cursor) --}}
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Pemegang Tempat</label>
                        <div id="wa-tokens" class="flex flex-wrap gap-1.5">
                            @foreach(['nama','no_telefon','emel','daerah','poskod','kod_rujukan','platform_sosial','sektor','nama_majikan','jawatan','gaji_asas','status_pekerjaan','masalah','bank_koperasi','link'] as $token)
                            <button type="button" draggable="true" data-token="{{ '{'.$token.'}' }}"
                                    class="wa-chip cursor-grab active:cursor-grabbing text-[11px] font-medium text-navy bg-navy/5 border border-navy/15 px-2 py-1 rounded-md hover:bg-navy/10 transition select-none">
                                {{ '{'.$token.'}' }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Templat Mesej</label>
                        <textarea name="whatsapp_template" id="wa_template" rows="8"
                                  class="w-full text-sm font-mono border border-slate-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy transition leading-relaxed"
                                  placeholder="Tulis mesej templat di sini...">{{ old('whatsapp_template', $settings['whatsapp_template'] ?? \App\Services\WhatsappMessageBuilder::DEFAULT_TEMPLATE) }}</textarea>
                    </div>

                    {{-- Live preview with sample data --}}
                    <div>
                        <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Pratonton</label>
                        <pre id="wa_preview" class="text-xs text-slate-600 bg-slate-50 border border-slate-100 rounded-lg px-3 py-2.5 whitespace-pre-wrap break-words font-sans leading-relaxed min-h-[3rem]"></pre>
                    </div>

                    <button type="submit"
                            class="bg-navy hover:bg-navy-dark text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                        Simpan Templat
                    </button>
                </form>
            </div>
            <script>
            (function () {
                const ta = document.getElementById('wa_template');
                const preview = document.getElementById('wa_preview');
                const SAMPLE = {
                    '{nama}': 'Ali bin Ahmad', '{no_telefon}': '+60 12-345 6789', '{emel}': 'ali@email.com',
                    '{daerah}': 'Petaling Jaya', '{poskod}': '47810', '{sektor}': 'Swasta',
                    '{kod_rujukan}': 'LIVE21', '{platform_sosial}': 'Facebook, TikTok',
                    '{nama_majikan}': 'Syarikat ABC Sdn Bhd', '{jawatan}': 'Pengurus', '{gaji_asas}': '4,500.00',
                    '{status_pekerjaan}': 'Tetap', '{masalah}': 'CCRIS, CTOS',
                    '{bank_koperasi}': 'Ya (Bank Rakyat)',
                    '{link}': 'https://…/dokumen/gabungan/12?signature=…',
                };

                function renderPreview() {
                    let out = ta.value;
                    for (const [token, val] of Object.entries(SAMPLE)) {
                        out = out.split(token).join(val);
                    }
                    preview.textContent = out;
                }

                // Insert token at the cursor position (click fallback + a11y).
                function insertAtCursor(text) {
                    const start = ta.selectionStart, end = ta.selectionEnd;
                    ta.value = ta.value.slice(0, start) + text + ta.value.slice(end);
                    ta.selectionStart = ta.selectionEnd = start + text.length;
                    ta.focus();
                    renderPreview();
                    ta.dispatchEvent(new Event('input', { bubbles: true }));
                }

                document.querySelectorAll('.wa-chip').forEach(function (chip) {
                    const token = chip.dataset.token;
                    chip.addEventListener('click', () => insertAtCursor(token));
                    chip.addEventListener('dragstart', (e) => e.dataTransfer.setData('text/plain', token));
                });

                // A plain <textarea> natively inserts dropped text at the drop point;
                // just refresh the preview afterwards.
                ta.addEventListener('drop', () => setTimeout(renderPreview, 0));
                ta.addEventListener('input', renderPreview);
                renderPreview();
            })();
            </script>
        </div>

    </div>
</section>

{{-- ── Unsaved-change highlighter + per-field revert (Tetapan Laman) ──────────
     Pure vanilla JS. Highlights a field amber when its value differs from what
     was loaded (the saved value), offers a "Pulih nilai asal" revert, and warns
     before leaving with unsaved changes. No DB / no backend involvement. --}}
<style>
    .rcms-field-dirty {
        border-color: #f59e0b !important;
        background-color: #fffbeb !important;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15) !important;
    }
    .rcms-revert {
        display: none;
        align-items: center;
        gap: 8px;
        margin-top: 6px;
        font-size: 11px;
    }
    .rcms-revert.is-visible { display: flex; }
    .rcms-revert-badge {
        color: #b45309; background: #fef3c7; border: 1px solid #fcd34d;
        border-radius: 6px; padding: 1px 8px; font-weight: 600;
    }
    .rcms-revert-btn {
        color: #1B2B6B; font-weight: 600; text-decoration: underline;
        cursor: pointer; background: none; border: none; padding: 0;
        display: inline-flex; align-items: center; gap: 3px;
    }
    .rcms-revert-btn:hover { color: #C9A840; }
</style>
<script>
(function () {
    const forms = document.querySelectorAll('form[action*="/admin/landing"]');
    let submitting = false;

    forms.forEach(function (form) {
        form.addEventListener('submit', function () { submitting = true; });

        const fields = form.querySelectorAll('input, textarea, select');
        fields.forEach(function (el) {
            // Skip non-editable / non-text inputs
            if (el.tagName === 'INPUT' && ['hidden', 'file', 'submit', 'button', 'checkbox', 'radio'].includes(el.type)) {
                return;
            }

            // Baseline = value as loaded (the saved value)
            const original = el.value;
            el.dataset.rcmsOriginal = original;

            // Build the revert control right after the field
            const revert = document.createElement('div');
            revert.className = 'rcms-revert';
            revert.innerHTML =
                '<span class="rcms-revert-badge">Belum disimpan</span>' +
                '<button type="button" class="rcms-revert-btn">↺ Pulih nilai asal</button>';
            el.insertAdjacentElement('afterend', revert);

            const btn = revert.querySelector('.rcms-revert-btn');

            function refresh() {
                const dirty = el.value !== el.dataset.rcmsOriginal;
                el.classList.toggle('rcms-field-dirty', dirty);
                revert.classList.toggle('is-visible', dirty);
            }

            btn.addEventListener('click', function () {
                el.value = el.dataset.rcmsOriginal;
                refresh();
                el.focus();
            });

            el.addEventListener('input', refresh);
            el.addEventListener('change', refresh);
        });
    });

    function hasUnsaved() {
        return !!document.querySelector('form[action*="/admin/landing"] .rcms-field-dirty');
    }

    // In-app navigation (nav links, logo, etc.): show the themed confirm modal.
    document.querySelectorAll('a[href]').forEach(function (a) {
        a.addEventListener('click', function (e) {
            if (submitting || a.target === '_blank') return;
            const href = a.getAttribute('href');
            if (!href || href.startsWith('#')) return;      // in-page anchor, no data loss
            if (!hasUnsaved()) return;
            e.preventDefault();
            window.rcmsConfirm({
                title: 'Perubahan Belum Disimpan',
                message: 'Anda ada perubahan yang belum disimpan pada halaman ini. Tinggalkan tanpa menyimpan?',
                confirmText: 'Tinggalkan',
                cancelText: 'Kekal di sini',
                danger: true,
            }).then(function (ok) {
                if (ok) { submitting = true; window.location.href = a.href; }
            });
        });
    });

    // Fallback for hard tab-close / refresh (native prompt — browsers can't theme this).
    window.addEventListener('beforeunload', function (e) {
        if (submitting) return;
        if (hasUnsaved()) { e.preventDefault(); e.returnValue = ''; }
    });
})();
</script>

{{-- Keep the scroll position across a save (POST → redirect otherwise reloads at the top). --}}
<script>
(function () {
    var KEY = 'rcmsTetapanScroll';

    // Remember where we were the moment any form on this page is submitted.
    document.querySelectorAll('form').forEach(function (form) {
        form.addEventListener('submit', function () {
            sessionStorage.setItem(KEY, String(window.scrollY));
        });
    });

    // After the reload, jump back to that position (once).
    if ('scrollRestoration' in history) history.scrollRestoration = 'manual';
    window.addEventListener('load', function () {
        var y = sessionStorage.getItem(KEY);
        if (y !== null) {
            sessionStorage.removeItem(KEY);
            window.scrollTo(0, parseInt(y, 10) || 0);
        }
    });
})();
</script>

@endsection
