@extends('layouts.main')

@section('title', 'Rahmah Consultancy Services — Solusi Kewangan, Masa Depan Terjamin')

@section('content')

    {{-- ── 1. HERO ──────────────────────────────────────────────────────── --}}
    <section class="relative overflow-hidden min-h-[88vh] flex items-center py-28 px-4 sm:px-6 lg:px-8">

        {{-- Background: Gemini image, people visible on right --}}
        <div class="hero-bg absolute inset-0"
             style="background-image: url('{{ asset('images/Gemini_Generated_Image_19mvqt19mvqt19mv.png') }}'); background-size: cover; background-position: right center;">
        </div>

        {{-- Overlay: strong on left (text), lighter on right (photo shows through) --}}
        <div class="absolute inset-0"
             style="background: linear-gradient(to right, rgba(15,26,69,0.93) 0%, rgba(15,26,69,0.82) 40%, rgba(15,26,69,0.62) 70%, rgba(15,26,69,0.42) 100%);"></div>

        {{-- Metallic gold top-border accent --}}
        <div class="absolute top-0 left-0 right-0 h-1"
             style="background: linear-gradient(90deg, #A8882E, #FFE87C, #C9A840, #FFE87C, #A8882E);"></div>

        {{-- Centered text content --}}
        <div class="relative max-w-3xl mx-auto text-center w-full">

            <p class="font-semibold text-xs tracking-widest uppercase mb-5" style="color:#C9A840;">
                Solusi Kewangan Terpercaya
            </p>

            <h1 class="hero-headline text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                Semak Kelayakan Anda<br>
                <span class="gold-metallic-text">Bersama Kami</span>
            </h1>

            <p class="text-slate-300 text-lg mb-8 max-w-2xl mx-auto leading-relaxed">
                Rahmah Consultancy Services menyediakan penyelesaian kewangan yang inovatif. Sertai lebih 10,000 pelanggan yang telah mempercayai kami.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <a href="#contact" class="btn-gold-metallic font-bold px-8 py-4 text-sm tracking-wide shadow-xl">
                    Semak Kelayakan Sekarang
                </a>
                <a href="#services" class="inline-block border border-white/30 hover:border-white/60 text-white font-semibold px-8 py-4 rounded-xl transition text-sm">
                    Ketahui Lebih Lanjut
                </a>
            </div>

            {{-- Service chip pills --}}
            <div class="flex flex-wrap items-center justify-center gap-3 mb-14">
                <a href="#services" class="service-chip">Perancangan Kewangan</a>
                <a href="#services" class="service-chip">Semakan Pinjaman</a>
                <a href="#services" class="service-chip">Restrukturisasi Hutang</a>
                <a href="#contact"  class="service-chip">Kakitangan Kerajaan</a>
                <a href="#contact"  class="service-chip">Pinjaman Peribadi</a>
            </div>

            {{-- Trust badges --}}
            <div class="flex flex-wrap items-center justify-center gap-6 text-slate-400 text-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color:#C9A840" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>Selamat & Terjamin</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color:#C9A840" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>Proses Pantas</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color:#C9A840" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                    <span>10,000+ Pelanggan</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" style="color:#C9A840" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/></svg>
                    <span>5+ Tahun Pengalaman</span>
                </div>
            </div>

        </div>
    </section>

    {{-- ── OWNER PROFILE ────────────────────────────────────────────────── --}}
    <section id="profil" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col md:flex-row items-center gap-12">

                {{-- Owner photo with metallic gold ring --}}
                <div class="flex-shrink-0 flex justify-center">
                    <div class="rounded-full p-[3px]" style="background: linear-gradient(135deg, #A8882E, #FFE87C, #C9A840, #FFE87C, #A8882E);">
                        <div class="rounded-full p-1 bg-white">
                            <img src="{{ asset('images/a5e960547f3d1fb5b0f887a23b10d43a~tplv-tiktokx-cropcenter_1080_1080.jpeg') }}"
                                 alt="Pengasas Rahmah Consultancy"
                                 class="w-44 h-44 sm:w-52 sm:h-52 rounded-full object-cover object-top block">
                        </div>
                    </div>
                </div>

                {{-- Biodata --}}
                <div class="text-center md:text-left">
                    <p class="text-gold font-semibold text-xs tracking-widest uppercase mb-2">Pengasas & Ketua Eksekutif</p>
                    <h2 class="text-2xl sm:text-3xl font-bold text-navy mb-1">Encik Khairul</h2>
                    <p class="text-slate-400 text-sm mb-5">Rahmah Consultancy Services</p>
                    <div class="w-12 h-0.5 mb-5 mx-auto md:mx-0" style="background: linear-gradient(90deg, #A8882E, #FFE87C, #A8882E);"></div>
                    <p class="text-slate-600 leading-relaxed mb-8 text-sm max-w-lg">
                        Dengan lebih 10 tahun pengalaman dalam industri kewangan Malaysia, beliau telah membantu ribuan pelanggan mencapai kebebasan kewangan melalui penyelesaian yang inovatif dan terancang. Pakar dalam perancangan kewangan, semakan pinjaman, dan restrukturisasi hutang — dikenali kerana pendekatan yang telus dan berorientasikan hasil.
                    </p>

                    {{-- Credential stats --}}
                    <div class="grid grid-cols-3 gap-4 max-w-sm mx-auto md:mx-0">
                        <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                            <p class="text-xl font-extrabold gold-metallic-text">10+</p>
                            <p class="text-xs text-slate-500 mt-1 leading-tight">Tahun Pengalaman</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                            <p class="text-xl font-extrabold gold-metallic-text">10k+</p>
                            <p class="text-xs text-slate-500 mt-1 leading-tight">Pelanggan Dibantu</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 text-center border border-slate-100">
                            <p class="text-xl font-extrabold gold-metallic-text">91%</p>
                            <p class="text-xs text-slate-500 mt-1 leading-tight">Kadar Kelulusan</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── 2. SERVICES ──────────────────────────────────────────────────── --}}
    <section id="services" class="py-20 px-4 bg-dot-grid">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-14">
                <p class="text-gold font-semibold text-xs tracking-widest uppercase mb-3">Apa Yang Kami Tawarkan</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-navy">Servis Kami</h2>
                <div class="mt-4 w-16 h-1 mx-auto rounded-full" style="background: linear-gradient(90deg, #A8882E, #FFE87C, #A8882E);"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <div class="group p-8 bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-gold transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6 transition-all duration-300 bg-gold-light text-gold group-hover:bg-gold group-hover:text-white">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-navy mb-3">Perancangan Kewangan</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Kami membantu anda merancang kewangan peribadi dengan strategi yang tersusun untuk mencapai kebebasan kewangan.</p>
                </div>

                <div class="group p-8 bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-gold transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6 transition-all duration-300 bg-gold-light text-gold group-hover:bg-gold group-hover:text-white">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-navy mb-3">Semakan Kelayakan Pinjaman</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Semak kelayakan pinjaman anda dengan cepat dan mudah. Kami akan pandukan anda sepanjang proses permohonan.</p>
                </div>

                <div class="group p-8 bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-gold transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center mb-6 transition-all duration-300 bg-gold-light text-gold group-hover:bg-gold group-hover:text-white">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 7l2.55 2.4A1 1 0 0116 11H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z" clip-rule="evenodd"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-navy mb-3">Pengurusan & Restrukturisasi Hutang</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">Penyelesaian komprehensif untuk membantu anda menguruskan dan merestrukturkan hutang dengan lebih efektif.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- ── 3. STATS ─────────────────────────────────────────────────────── --}}
    <section id="stats" class="py-20 px-4 bg-navy">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-slate-700">
                <div class="flex flex-col items-center px-4">
                    <span class="text-4xl sm:text-5xl font-extrabold gold-metallic-text mb-2">10,000+</span>
                    <span class="text-slate-300 text-sm font-medium">Individu & Prospek Dibantu</span>
                </div>
                <div class="flex flex-col items-center px-4">
                    <span class="text-4xl sm:text-5xl font-extrabold gold-metallic-text mb-2">4</span>
                    <span class="text-slate-300 text-sm font-medium">Sektor Dilayan</span>
                    <span class="text-slate-500 text-xs mt-1">Kerajaan · GLC · Berkanun · Swasta</span>
                </div>
                <div class="flex flex-col items-center px-4">
                    <span class="text-4xl sm:text-5xl font-extrabold gold-metallic-text mb-2">5+</span>
                    <span class="text-slate-300 text-sm font-medium">Tahun Pengalaman</span>
                </div>
                <div class="flex flex-col items-center px-4">
                    <span class="text-4xl sm:text-5xl font-extrabold gold-metallic-text mb-2">0%</span>
                    <span class="text-slate-300 text-sm font-medium">Bayaran Pendahuluan</span>
                    <span class="text-slate-500 text-xs mt-1">Bayar hanya selepas lulus</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ── 4. TESTIMONIALS ─────────────────────────────────────────────── --}}
    <section class="py-20 px-4 bg-gold-light">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-gold font-semibold text-xs tracking-widest uppercase mb-3">Testimoni Pelanggan</p>
                <h2 class="text-3xl font-bold text-navy">Apa Kata Mereka?</h2>
                <div class="mt-4 w-16 h-1 mx-auto rounded-full" style="background: linear-gradient(90deg, #A8882E, #FFE87C, #A8882E);"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="relative bg-white p-8 rounded-2xl shadow-sm flex flex-col">
                    <span class="absolute top-3 left-6 text-6xl text-gold font-serif leading-none opacity-20">"</span>
                    <p class="text-slate-700 text-sm italic leading-relaxed relative z-10 pt-4 flex-grow">
                        Alhamdulillah, pelanggan berjaya mendapatkan solusi penyatuan hutang selepas semakan kelayakan dibuat secara teratur.
                    </p>
                    <div class="mt-6 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-navy flex items-center justify-center text-white font-bold text-xs flex-shrink-0">RCS</div>
                        <div>
                            <p class="font-semibold text-navy text-sm">Pelanggan RCS</p>
                            <p class="text-slate-400 text-xs">Penyatuan Hutang</p>
                        </div>
                    </div>
                </div>

                <div class="relative bg-white p-8 rounded-2xl shadow-sm flex flex-col">
                    <span class="absolute top-3 left-6 text-6xl text-gold font-serif leading-none opacity-20">"</span>
                    <p class="text-slate-700 text-sm italic leading-relaxed relative z-10 pt-4 flex-grow">
                        Pelanggan lebih jelas tentang komitmen bulanan dan pilihan pembiayaan yang sesuai selepas sesi konsultasi.
                    </p>
                    <div class="mt-6 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-navy flex items-center justify-center text-white font-bold text-xs flex-shrink-0">RCS</div>
                        <div>
                            <p class="font-semibold text-navy text-sm">Pelanggan RCS</p>
                            <p class="text-slate-400 text-xs">Konsultasi Kewangan</p>
                        </div>
                    </div>
                </div>

                <div class="relative bg-white p-8 rounded-2xl shadow-sm flex flex-col">
                    <span class="absolute top-3 left-6 text-6xl text-gold font-serif leading-none opacity-20">"</span>
                    <p class="text-slate-700 text-sm italic leading-relaxed relative z-10 pt-4 flex-grow">
                        Proses semakan dibantu daripada peringkat dokumen sehingga permohonan dihantar kepada pihak berkaitan.
                    </p>
                    <div class="mt-6 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-navy flex items-center justify-center text-white font-bold text-xs flex-shrink-0">RCS</div>
                        <div>
                            <p class="font-semibold text-navy text-sm">Pelanggan RCS</p>
                            <p class="text-slate-400 text-xs">Semakan Kelayakan</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── 5. FAQS ──────────────────────────────────────────────────────── --}}
    <section id="faqs" class="py-20 px-4 bg-dot-grid">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-gold font-semibold text-xs tracking-widest uppercase mb-3">Ada Soalan?</p>
                <h2 class="text-3xl font-bold text-navy">Soalan Lazim</h2>
                <div class="mt-4 w-16 h-1 mx-auto rounded-full" style="background: linear-gradient(90deg, #A8882E, #FFE87C, #A8882E);"></div>
            </div>
            <div class="space-y-3">

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Apakah servis utama RCS?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        RCS menyediakan khidmat konsultasi kewangan, semakan kelayakan pembiayaan peribadi, penyatuan hutang dan panduan berkaitan isu CCRIS, CTOS, AKPK, SAA, legal action serta komitmen kewangan.
                    </div>
                </div>

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Siapa yang boleh membuat semakan?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        Semakan terbuka kepada kakitangan kerajaan, GLC, badan berkanun dan pekerja swasta yang mempunyai pendapatan tetap serta dokumen sokongan yang lengkap.
                    </div>
                </div>

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Apakah kelayakan asas untuk semakan awal?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        <ul class="space-y-1 mb-3">
                            <li>• <strong>Kerajaan:</strong> Gaji asas minimum RM1,500</li>
                            <li>• <strong>GLC / Badan Berkanun:</strong> Gaji asas minimum RM2,500</li>
                            <li>• <strong>Swasta:</strong> Gaji asas minimum RM3,000</li>
                        </ul>
                        <p class="text-slate-400 text-xs italic">Kelayakan sebenar masih bergantung kepada dokumen, rekod kewangan dan polisi bank / koperasi.</p>
                    </div>
                </div>

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Adakah perlu bayar dahulu sebelum semakan dibuat?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        Tidak. RCS mengamalkan konsep bayaran hanya apabila permohonan berjaya diluluskan, tertakluk kepada terma perkhidmatan.
                    </div>
                </div>

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Dokumen apa yang diperlukan untuk semakan awal?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        <p class="font-semibold text-navy mb-1">Kerajaan / GLC / Badan Berkanun:</p>
                        <ol class="list-decimal list-inside space-y-0.5 mb-3 ml-2">
                            <li>Slip gaji 3 bulan terkini</li>
                            <li>Laporan CTOS terkini</li>
                        </ol>
                        <p class="font-semibold text-navy mb-1">Swasta:</p>
                        <ol class="list-decimal list-inside space-y-0.5 ml-2">
                            <li>Slip gaji 3 bulan terkini</li>
                            <li>Laporan CTOS terkini</li>
                            <li>Penyata EPF 2 tahun terkini</li>
                        </ol>
                    </div>
                </div>

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Bolehkah pelanggan yang ada CCRIS, CTOS, AKPK, SAA atau legal action membuat semakan?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        Boleh. Namun kelayakan bergantung kepada tahap rekod kewangan, jenis isu, dokumen sokongan, status pekerjaan dan polisi pihak bank / koperasi.
                    </div>
                </div>

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Adakah RCS menjamin kelulusan pinjaman?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        Tidak. Kelulusan adalah tertakluk sepenuhnya kepada penilaian pihak bank atau koperasi. RCS membantu dari segi semakan awal, konsultasi, penyusunan dokumen dan cadangan solusi yang bersesuaian.
                    </div>
                </div>

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Berapa lama proses permohonan?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        Tempoh proses bergantung kepada kelengkapan dokumen, jenis produk pembiayaan, polisi institusi kewangan dan keadaan rekod pelanggan.
                    </div>
                </div>

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Adakah maklumat pelanggan dirahsiakan?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        Ya. Semua maklumat dan dokumen pelanggan digunakan hanya untuk tujuan semakan dan permohonan berkaitan, tertakluk kepada persetujuan pelanggan.
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ── 6. FORM ──────────────────────────────────────────────────────── --}}
    <section id="contact" class="py-20 px-4 bg-slate-50">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-10">
                <p class="text-gold font-semibold text-xs tracking-widest uppercase mb-3">Mulakan Sekarang</p>
                <h2 class="text-3xl font-bold text-navy mb-3">Semak Kelayakan Anda</h2>
                <p class="text-slate-500 text-sm">Isi maklumat ringkas & upload dokumen untuk semakan awal.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-navy px-6 py-4">
                    <p class="text-white font-semibold text-sm">Borang Semakan Kelayakan</p>
                    <p class="text-slate-400 text-xs mt-0.5">Semua maklumat adalah SULIT dan dilindungi</p>
                </div>

                <form id="borang-permohonan" action="#" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
                    @csrf

                    {{-- Group 1: Maklumat Peribadi --}}
                    <fieldset>
                        <legend class="flex items-center gap-2 text-xs font-bold text-navy uppercase tracking-widest mb-5 pb-2 border-b border-gold-light w-full">
                            <span class="w-5 h-5 bg-gold-light text-gold rounded flex items-center justify-center font-bold">1</span>
                            Maklumat Peribadi
                        </legend>
                        <div class="space-y-4">
                            <div>
                                <label for="nama" class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Penuh <span class="text-rose-500">*</span></label>
                                <input type="text" id="nama" name="nama" placeholder="Nama seperti dalam IC" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition" required>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="no_tele" class="block text-xs font-semibold text-slate-600 mb-1.5">No. Telefon / WhatsApp <span class="text-rose-500">*</span></label>
                                    <input type="tel" id="no_tele" name="no_tele" placeholder="+60 12-345 6789" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition" required>
                                </div>
                                <div>
                                    <label for="alamat_emel" class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat Emel <span class="text-slate-400 font-normal">(Pilihan)</span></label>
                                    <input type="email" id="alamat_emel" name="alamat_emel" placeholder="nama@emel.com" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="daerah" class="block text-xs font-semibold text-slate-600 mb-1.5">Daerah <span class="text-rose-500">*</span></label>
                                    <input type="text" id="daerah" name="daerah" placeholder="Contoh: Petaling Jaya" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition" required>
                                </div>
                                <div>
                                    <label for="poskod" class="block text-xs font-semibold text-slate-600 mb-1.5">Poskod <span class="text-rose-500">*</span></label>
                                    <input type="text" id="poskod" name="poskod" placeholder="Contoh: 47810" maxlength="5" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition" required>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Group 2: Maklumat Pekerjaan --}}
                    <fieldset>
                        <legend class="flex items-center gap-2 text-xs font-bold text-navy uppercase tracking-widest mb-5 pb-2 border-b border-gold-light w-full">
                            <span class="w-5 h-5 bg-gold-light text-gold rounded flex items-center justify-center font-bold">2</span>
                            Maklumat Pekerjaan
                        </legend>
                        <div class="space-y-4">
                            <div>
                                <label for="sektor_pekerjaan" class="block text-xs font-semibold text-slate-600 mb-1.5">Sektor Pekerjaan <span class="text-rose-500">*</span></label>
                                <select id="sektor_pekerjaan" name="sektor_pekerjaan" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border bg-white text-sm transition" required>
                                    <option value="">Sila pilih sektor...</option>
                                    <option value="kerajaan">Kerajaan</option>
                                    <option value="glc">GLC (Syarikat Berkaitan Kerajaan)</option>
                                    <option value="berkanun">Badan Berkanun</option>
                                    <option value="swasta">Swasta</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="nama_majikan" class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Majikan <span class="text-rose-500">*</span></label>
                                    <input type="text" id="nama_majikan" name="nama_majikan" placeholder="Contoh: Kementerian Pendidikan" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition" required>
                                </div>
                                <div>
                                    <label for="jawatan" class="block text-xs font-semibold text-slate-600 mb-1.5">Jawatan <span class="text-rose-500">*</span></label>
                                    <input type="text" id="jawatan" name="jawatan" placeholder="Contoh: Pegawai Tadbir" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="gaji_asas" class="block text-xs font-semibold text-slate-600 mb-1.5">Gaji Asas (RM) <span class="text-rose-500">*</span></label>
                                    <input type="number" id="gaji_asas" name="gaji_asas" placeholder="Contoh: 3500" min="0" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition" required>
                                </div>
                                <div>
                                    <label for="status_pekerjaan" class="block text-xs font-semibold text-slate-600 mb-1.5">Status Pekerjaan <span class="text-rose-500">*</span></label>
                                    <select id="status_pekerjaan" name="status_pekerjaan" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border bg-white text-sm transition" required>
                                        <option value="">Sila pilih...</option>
                                        <option value="tetap">Tetap</option>
                                        <option value="kontrak">Kontrak</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-2">Masalah Utama <span class="text-rose-500">*</span> <span class="text-slate-400 font-normal">(Boleh pilih lebih dari satu)</span></label>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="flex items-center gap-2 p-2.5 rounded-lg border border-slate-200 hover:border-gold cursor-pointer text-sm text-slate-600 transition has-[:checked]:border-gold has-[:checked]:bg-gold-light">
                                        <input type="checkbox" name="masalah[]" value="komitmen_tinggi" class="accent-navy flex-shrink-0"> Komitmen Tinggi
                                    </label>
                                    <label class="flex items-center gap-2 p-2.5 rounded-lg border border-slate-200 hover:border-gold cursor-pointer text-sm text-slate-600 transition has-[:checked]:border-gold has-[:checked]:bg-gold-light">
                                        <input type="checkbox" name="masalah[]" value="ccris" class="accent-navy flex-shrink-0"> CCRIS
                                    </label>
                                    <label class="flex items-center gap-2 p-2.5 rounded-lg border border-slate-200 hover:border-gold cursor-pointer text-sm text-slate-600 transition has-[:checked]:border-gold has-[:checked]:bg-gold-light">
                                        <input type="checkbox" name="masalah[]" value="ctos" class="accent-navy flex-shrink-0"> CTOS
                                    </label>
                                    <label class="flex items-center gap-2 p-2.5 rounded-lg border border-slate-200 hover:border-gold cursor-pointer text-sm text-slate-600 transition has-[:checked]:border-gold has-[:checked]:bg-gold-light">
                                        <input type="checkbox" name="masalah[]" value="akpk" class="accent-navy flex-shrink-0"> AKPK
                                    </label>
                                    <label class="flex items-center gap-2 p-2.5 rounded-lg border border-slate-200 hover:border-gold cursor-pointer text-sm text-slate-600 transition has-[:checked]:border-gold has-[:checked]:bg-gold-light">
                                        <input type="checkbox" name="masalah[]" value="saa" class="accent-navy flex-shrink-0"> SAA
                                    </label>
                                    <label class="flex items-center gap-2 p-2.5 rounded-lg border border-slate-200 hover:border-gold cursor-pointer text-sm text-slate-600 transition has-[:checked]:border-gold has-[:checked]:bg-gold-light">
                                        <input type="checkbox" name="masalah[]" value="legal_action" class="accent-navy flex-shrink-0"> Legal Action
                                    </label>
                                    <label class="flex items-center gap-2 p-2.5 rounded-lg border border-slate-200 hover:border-gold cursor-pointer text-sm text-slate-600 transition col-span-2 has-[:checked]:border-gold has-[:checked]:bg-gold-light">
                                        <input type="checkbox" name="masalah[]" value="lain_lain" class="accent-navy flex-shrink-0"> Lain-lain
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Group 3: Dokumen Sokongan --}}
                    <fieldset>
                        <legend class="flex items-center gap-2 text-xs font-bold text-navy uppercase tracking-widest mb-5 pb-2 border-b border-gold-light w-full">
                            <span class="w-5 h-5 bg-gold-light text-gold rounded flex items-center justify-center font-bold">3</span>
                            Dokumen Sokongan
                        </legend>
                        <div class="space-y-4">
                            <div>
                                <label for="slip_gaji" class="block text-xs font-semibold text-slate-600 mb-1.5">Slip Gaji 3 Bulan Terkini <span class="text-rose-500">*</span></label>
                                <div class="border-2 border-dashed border-slate-200 rounded-lg p-4 hover:border-gold transition">
                                    <input type="file" id="slip_gaji" name="slip_gaji[]" multiple class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-navy file:text-white hover:file:bg-navy-dark transition" required>
                                    <p class="text-[10px] text-slate-400 mt-1.5">Boleh muat naik lebih dari satu fail. PDF atau imej. Maks 5MB setiap fail.</p>
                                </div>
                            </div>
                            <div>
                                <label for="ctos_report" class="block text-xs font-semibold text-slate-600 mb-1.5">Laporan CTOS Terkini <span class="text-rose-500">*</span></label>
                                <div class="border-2 border-dashed border-slate-200 rounded-lg p-4 hover:border-gold transition">
                                    <input type="file" id="ctos_report" name="ctos_report" class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-navy file:text-white hover:file:bg-navy-dark transition" required>
                                    <p class="text-[10px] text-slate-400 mt-1.5">PDF atau imej. Maks 5MB.</p>
                                </div>
                            </div>
                            {{-- EPF: shown only for Swasta --}}
                            <div id="epf_section" class="hidden">
                                <label for="penyata_epf" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                    Penyata EPF 2 Tahun Terkini <span class="text-rose-500">*</span>
                                    <span class="text-blue-500 font-normal ml-1">(Swasta sahaja)</span>
                                </label>
                                <div class="border-2 border-dashed border-blue-200 rounded-lg p-4 hover:border-gold transition">
                                    <input type="file" id="penyata_epf" name="penyata_epf" class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-navy file:text-white hover:file:bg-navy-dark transition">
                                    <p class="text-[10px] text-slate-400 mt-1.5">PDF atau imej. Maks 5MB.</p>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <button type="button" onclick="openConsentModal()" class="btn-gold-metallic w-full font-bold py-4 px-4 text-sm tracking-wide shadow-sm">
                        Hantar Permohonan Sekarang
                    </button>
                    <p class="text-center text-[10px] text-slate-400">
                        Dengan menghantar borang ini, anda bersetuju dengan <a href="#" class="text-navy underline">Dasar Privasi</a> kami.
                    </p>
                </form>

                {{-- Consent Modal --}}
                <div id="consent-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
                    {{-- Backdrop --}}
                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeConsentModal()"></div>

                    {{-- Modal card --}}
                    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] flex flex-col">

                        {{-- Header --}}
                        <div class="px-6 pt-6 pb-4 border-b border-slate-100 flex items-start justify-between gap-4 flex-shrink-0">
                            <div>
                                <h3 class="font-bold text-slate-800 text-base leading-snug">Pengesahan & Persetujuan</h3>
                                <p class="text-xs text-slate-400 mt-0.5">Sila baca dan tandakan persetujuan anda sebelum menghantar</p>
                            </div>
                            <button onclick="closeConsentModal()" class="text-slate-400 hover:text-slate-600 transition mt-0.5 flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        {{-- Scrollable body --}}
                        <div class="overflow-y-auto px-6 py-5 space-y-5 flex-1">

                            {{-- Declaration text --}}
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Saya mengesahkan bahawa semua maklumat dan dokumen yang diberikan adalah benar. Saya bersetuju membenarkan <span class="font-semibold text-navy">Rahmah Consultancy Services</span> mengumpul, menyimpan, memproses dan berkongsi maklumat saya kepada bank, koperasi, institusi kewangan, banker, panel atau rakan strategik berkaitan bagi tujuan semakan kelayakan, penyatuan hutang, permohonan pembiayaan, pemulihan rekod dan susulan kes. Saya faham bahawa semakan ini <span class="font-semibold">tidak menjamin kelulusan</span>.
                                </p>
                            </div>

                            {{-- Mandatory checkboxes --}}
                            <div class="space-y-3">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Wajib</p>

                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" id="modal-consent-pdpa" class="mt-0.5 accent-navy flex-shrink-0 w-4 h-4">
                                    <span class="text-xs text-slate-600 leading-relaxed group-hover:text-slate-800 transition">
                                        Saya telah membaca, memahami dan bersetuju dengan <a href="#" class="text-navy underline font-medium">Notis Perlindungan Data Peribadi</a>.
                                    </span>
                                </label>

                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" id="modal-consent-contact" class="mt-0.5 accent-navy flex-shrink-0 w-4 h-4">
                                    <span class="text-xs text-slate-600 leading-relaxed group-hover:text-slate-800 transition">
                                        Saya bersetuju untuk dihubungi melalui WhatsApp/telefon/emel bagi tujuan semakan dan susulan kes.
                                    </span>
                                </label>
                            </div>

                            {{-- Optional marketing checkbox --}}
                            <div class="pt-2 border-t border-slate-100 space-y-3">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pilihan</p>

                                <label class="flex items-start gap-3 cursor-pointer group">
                                    <input type="checkbox" id="modal-consent-marketing" name="consent_marketing" class="mt-0.5 accent-navy flex-shrink-0 w-4 h-4">
                                    <span class="text-xs text-slate-500 leading-relaxed group-hover:text-slate-700 transition">
                                        Saya bersetuju menerima maklumat promosi/pendidikan kewangan daripada Rahmah Consultancy Services.
                                    </span>
                                </label>
                            </div>

                            {{-- Inline error --}}
                            <p id="consent-error" class="hidden text-xs text-rose-500 font-medium">
                                Sila tandakan kedua-dua kotak wajib sebelum menghantar.
                            </p>

                        </div>

                        {{-- Footer actions --}}
                        <div class="px-6 py-4 border-t border-slate-100 flex gap-3 flex-shrink-0">
                            <button onclick="closeConsentModal()" class="flex-1 py-2.5 px-4 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                                Batal
                            </button>
                            <button onclick="submitWithConsent()" class="flex-1 btn-gold-metallic py-2.5 px-4 text-sm font-bold rounded-xl">
                                Hantar Permohonan
                            </button>
                        </div>

                    </div>
                </div>

                <script>
                function openConsentModal() {
                    const form = document.getElementById('borang-permohonan') || document.querySelector('form');
                    if (form && !form.checkValidity()) {
                        form.reportValidity();
                        return;
                    }
                    document.getElementById('consent-modal').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }

                function closeConsentModal() {
                    document.getElementById('consent-modal').classList.add('hidden');
                    document.body.style.overflow = '';
                    document.getElementById('consent-error').classList.add('hidden');
                }

                function submitWithConsent() {
                    const pdpa    = document.getElementById('modal-consent-pdpa').checked;
                    const contact = document.getElementById('modal-consent-contact').checked;

                    if (!pdpa || !contact) {
                        document.getElementById('consent-error').classList.remove('hidden');
                        return;
                    }

                    // Sync marketing opt-in value into the real form before submit
                    const marketing = document.getElementById('modal-consent-marketing').checked;
                    const form = document.getElementById('borang-permohonan') || document.querySelector('form');
                    let hiddenMarketing = form.querySelector('input[name="consent_marketing"]');
                    if (!hiddenMarketing) {
                        hiddenMarketing = document.createElement('input');
                        hiddenMarketing.type  = 'hidden';
                        hiddenMarketing.name  = 'consent_marketing';
                        form.appendChild(hiddenMarketing);
                    }
                    hiddenMarketing.value = marketing ? '1' : '0';

                    form.submit();
                }

                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape') closeConsentModal();
                });
                </script>
            </div>

            <div class="mt-6 flex flex-wrap justify-center gap-6 text-sm text-slate-500">
                <a href="mailto:hello@rahmahconsulting.com" class="flex items-center gap-2 hover:text-navy transition">
                    <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    [Email RCS]
                </a>
                <a href="tel:" class="flex items-center gap-2 hover:text-navy transition">
                    <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    [No. WhatsApp RCS]
                </a>
            </div>
        </div>
    </section>

    <script>
        document.querySelectorAll('.faq-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var answer = this.nextElementSibling;
                var icon = this.querySelector('.faq-icon');
                answer.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });

        // Show EPF upload only for Swasta sector
        document.getElementById('sektor_pekerjaan').addEventListener('change', function () {
            var epfSection = document.getElementById('epf_section');
            var epfInput   = document.getElementById('penyata_epf');
            if (this.value === 'swasta') {
                epfSection.classList.remove('hidden');
                epfInput.required = true;
            } else {
                epfSection.classList.add('hidden');
                epfInput.required = false;
                epfInput.value = '';
            }
        });
    </script>

@endsection
