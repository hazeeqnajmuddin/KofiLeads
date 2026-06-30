@extends('layouts.main')

@section('title', 'Rahmah Consultancy Services — Solusi Kewangan, Masa Depan Terjamin')

@section('content')

    {{-- ── 1. HERO ──────────────────────────────────────────────────────── --}}
    <section class="relative bg-navy overflow-hidden py-28 px-4 sm:px-6 lg:px-8">
        {{-- Gold top-border accent --}}
        <div class="absolute top-0 left-0 right-0 h-1 bg-gold"></div>

        {{-- Decorative circles --}}
        <div class="absolute -top-20 -right-20 w-96 h-96 rounded-full opacity-10" style="background:#C9A840"></div>
        <div class="absolute -bottom-32 -left-20 w-80 h-80 rounded-full opacity-10" style="background:#C9A840"></div>

        <div class="relative max-w-4xl mx-auto text-center">
            <p class="text-gold font-semibold text-xs tracking-widest uppercase mb-5">Solusi Kewangan Terpercaya</p>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
                Semak Kelayakan Anda<br>
                <span class="text-gold">Bersama Kami</span>
            </h1>
            <p class="text-slate-300 text-lg mb-10 max-w-2xl mx-auto leading-relaxed">
                Rahmah Consultancy Services menyediakan penyelesaian kewangan yang inovatif. Sertai lebih 10,000 pelanggan yang telah mempercayai kami.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#contact" class="inline-block bg-gold hover:bg-gold-dark text-navy-dark font-bold px-8 py-4 rounded-xl shadow-lg transition text-sm tracking-wide">
                    Semak Kelayakan Sekarang
                </a>
                <a href="#services" class="inline-block border border-white/30 hover:border-gold text-white hover:text-gold font-semibold px-8 py-4 rounded-xl transition text-sm">
                    Ketahui Lebih Lanjut
                </a>
            </div>

            {{-- Trust badges --}}
            <div class="mt-14 flex flex-wrap items-center justify-center gap-6 text-slate-400 text-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>Selamat & Terjamin</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span>Proses Pantas</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/></svg>
                    <span>10,000+ Pelanggan</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/></svg>
                    <span>5+ Tahun Pengalaman</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ── 2. SERVICES ──────────────────────────────────────────────────── --}}
    <section id="services" class="py-20 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-14">
                <p class="text-gold font-semibold text-xs tracking-widest uppercase mb-3">Apa Yang Kami Tawarkan</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-navy">Servis Kami</h2>
                <div class="mt-4 w-16 h-1 bg-gold mx-auto rounded-full"></div>
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
                    <span class="text-4xl sm:text-5xl font-extrabold text-gold mb-2">10k+</span>
                    <span class="text-slate-300 text-sm font-medium">Pelanggan Berpuas Hati</span>
                </div>
                <div class="flex flex-col items-center px-4">
                    <span class="text-4xl sm:text-5xl font-extrabold text-gold mb-2">91%</span>
                    <span class="text-slate-300 text-sm font-medium">Kadar Kelulusan</span>
                </div>
                <div class="flex flex-col items-center px-4">
                    <span class="text-4xl sm:text-5xl font-extrabold text-gold mb-2">5+</span>
                    <span class="text-slate-300 text-sm font-medium">Tahun Pengalaman</span>
                </div>
                <div class="flex flex-col items-center px-4">
                    <span class="text-4xl sm:text-5xl font-extrabold text-gold mb-2">RM50j+</span>
                    <span class="text-slate-300 text-sm font-medium">Pinjaman Difasilitasi</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ── 4. TESTIMONIAL ───────────────────────────────────────────────── --}}
    <section class="py-20 px-4 bg-gold-light">
        <div class="max-w-3xl mx-auto text-center">
            <p class="text-gold font-semibold text-xs tracking-widest uppercase mb-3">Testimoni Pelanggan</p>
            <h2 class="text-3xl font-bold text-navy mb-10">Apa Kata Mereka?</h2>
            <div class="relative bg-white p-10 rounded-2xl shadow-sm">
                <span class="absolute top-4 left-7 text-7xl text-gold font-serif leading-none opacity-20">"</span>
                <p class="text-slate-700 text-lg italic leading-relaxed relative z-10">
                    Servis yang hebat! Rahmah Consultancy membantu saya mendapatkan pinjaman yang sesuai dengan keperluan saya. Proses cepat, mesra, dan sangat profesional.
                </p>
                <span class="absolute bottom-0 right-7 text-7xl text-gold font-serif leading-none opacity-20">"</span>
            </div>
            <div class="mt-7 flex items-center justify-center gap-3">
                <div class="w-11 h-11 rounded-full bg-navy flex items-center justify-center text-white font-bold text-sm">AA</div>
                <div class="text-left">
                    <p class="font-semibold text-navy text-sm">Ahmad Albab</p>
                    <p class="text-slate-500 text-xs">CEO, Karipap Pistachio</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── 5. FAQS ──────────────────────────────────────────────────────── --}}
    <section id="faqs" class="py-20 px-4 bg-white">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-gold font-semibold text-xs tracking-widest uppercase mb-3">Ada Soalan?</p>
                <h2 class="text-3xl font-bold text-navy">Soalan Lazim</h2>
                <div class="mt-4 w-16 h-1 bg-gold mx-auto rounded-full"></div>
            </div>
            <div class="space-y-3">

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Bagaimana kelayakan disemak?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        Kelayakan disemak berdasarkan dokumen yang dihantar, termasuk slip gaji, dokumen pengenalan, dan laporan CTOS. Pasukan kami akan menghubungi anda dalam masa 1–3 hari bekerja.
                    </div>
                </div>

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Berapa lama proses kelulusan?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        Proses kelulusan biasanya mengambil masa 3–7 hari bekerja bergantung pada jenis pinjaman dan kelengkapan dokumen yang dihantar.
                    </div>
                </div>

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Adakah perkhidmatan ini percuma?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        Ya, semakan kelayakan adalah percuma. Tiada caj tersembunyi. Kami hanya dibayar apabila pinjaman anda berjaya diluluskan.
                    </div>
                </div>

                <div class="faq-item bg-slate-50 rounded-xl border border-slate-100 overflow-hidden">
                    <button class="faq-btn w-full flex justify-between items-center p-5 text-left font-semibold text-navy hover:text-gold transition text-sm">
                        <span>Dokumen apa yang diperlukan?</span>
                        <svg class="faq-icon w-5 h-5 text-gold flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="faq-answer hidden px-5 pb-5 text-slate-600 text-sm leading-relaxed">
                        Dokumen asas: MyKad, slip gaji 3 bulan terkini, dan nombor telefon aktif. Laporan CTOS dan bil elektrik adalah pilihan tetapi mempercepatkan proses semakan.
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
                <p class="text-slate-500 text-sm">Isi borang di bawah dan pasukan kami akan menghubungi anda dalam masa 24 jam.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="bg-navy px-6 py-4">
                    <p class="text-white font-semibold text-sm">Borang Semakan Kelayakan</p>
                    <p class="text-slate-400 text-xs mt-0.5">Semua maklumat adalah SULIT dan dilindungi</p>
                </div>

                <form action="#" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-8">
                    @csrf

                    {{-- Group 1: Personal Info --}}
                    <fieldset>
                        <legend class="flex items-center gap-2 text-xs font-bold text-navy uppercase tracking-widest mb-5 pb-2 border-b border-gold-light w-full">
                            <span class="w-5 h-5 bg-gold-light text-gold rounded flex items-center justify-center font-bold">1</span>
                            Maklumat Peribadi
                        </legend>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="nama" class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Penuh <span class="text-rose-500">*</span></label>
                                    <input type="text" id="nama" name="nama" placeholder="Nama seperti dalam IC" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition" required>
                                </div>
                                <div>
                                    <label for="umur" class="block text-xs font-semibold text-slate-600 mb-1.5">Umur <span class="text-slate-400 font-normal">(Pilihan)</span></label>
                                    <input type="number" id="umur" name="umur" placeholder="Contoh: 30" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="no_tele" class="block text-xs font-semibold text-slate-600 mb-1.5">No. Telefon <span class="text-rose-500">*</span></label>
                                    <input type="tel" id="no_tele" name="no_tele" placeholder="+60 12-345 6789" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition" required>
                                </div>
                                <div>
                                    <label for="alamat_emel" class="block text-xs font-semibold text-slate-600 mb-1.5">Alamat Emel <span class="text-rose-500">*</span></label>
                                    <input type="email" id="alamat_emel" name="alamat_emel" placeholder="nama@emel.com" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="pekerjaan" class="block text-xs font-semibold text-slate-600 mb-1.5">Pekerjaan <span class="text-rose-500">*</span></label>
                                    <input type="text" id="pekerjaan" name="pekerjaan" placeholder="Contoh: Jurutera, Guru" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition" required>
                                </div>
                                <div>
                                    <label for="industri_pekerjaan" class="block text-xs font-semibold text-slate-600 mb-1.5">Industri <span class="text-slate-400 font-normal">(Pilihan)</span></label>
                                    <input type="text" id="industri_pekerjaan" name="industri_pekerjaan" placeholder="Contoh: Pendidikan, IT" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border text-sm transition">
                                </div>
                            </div>
                            <div>
                                <label for="kakitangan_kerajaan" class="block text-xs font-semibold text-slate-600 mb-1.5">Kakitangan Kerajaan? <span class="text-rose-500">*</span></label>
                                <select id="kakitangan_kerajaan" name="kakitangan_kerajaan" class="w-full rounded-lg border-slate-200 focus:border-navy focus:ring-navy p-2.5 border bg-white text-sm transition" required>
                                    <option value="">Sila pilih...</option>
                                    <option value="ya">Ya</option>
                                    <option value="tidak">Tidak</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Group 2: Documents --}}
                    <fieldset>
                        <legend class="flex items-center gap-2 text-xs font-bold text-navy uppercase tracking-widest mb-5 pb-2 border-b border-gold-light w-full">
                            <span class="w-5 h-5 bg-gold-light text-gold rounded flex items-center justify-center font-bold">2</span>
                            Dokumen Sokongan
                        </legend>
                        <div class="space-y-4">
                            <div>
                                <label for="dokumen_pengenalan" class="block text-xs font-semibold text-slate-600 mb-1.5">Dokumen Pengenalan (MyKad) <span class="text-rose-500">*</span></label>
                                <div class="border-2 border-dashed border-slate-200 rounded-lg p-4 hover:border-gold transition">
                                    <input type="file" id="dokumen_pengenalan" name="dokumen_pengenalan" class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-navy file:text-white hover:file:bg-navy-dark transition" required>
                                    <p class="text-[10px] text-slate-400 mt-1.5">PDF, JPG, atau PNG. Maks 5MB.</p>
                                </div>
                            </div>
                            <div>
                                <label for="slip_gaji" class="block text-xs font-semibold text-slate-600 mb-1.5">Slip Gaji 3 Bulan Terkini <span class="text-rose-500">*</span></label>
                                <div class="border-2 border-dashed border-slate-200 rounded-lg p-4 hover:border-gold transition">
                                    <input type="file" id="slip_gaji" name="slip_gaji" multiple class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-navy file:text-white hover:file:bg-navy-dark transition" required>
                                    <p class="text-[10px] text-slate-400 mt-1.5">Boleh muat naik lebih dari satu fail. PDF atau imej.</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="ctos_report" class="block text-xs font-semibold text-slate-600 mb-1.5">Laporan CTOS <span class="text-slate-400 font-normal">(Pilihan)</span></label>
                                    <div class="border-2 border-dashed border-slate-200 rounded-lg p-3 hover:border-gold transition">
                                        <input type="file" id="ctos_report" name="ctos_report" class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition">
                                    </div>
                                </div>
                                <div>
                                    <label for="bil_eletrik" class="block text-xs font-semibold text-slate-600 mb-1.5">Bil Elektrik <span class="text-slate-400 font-normal">(Pilihan)</span></label>
                                    <div class="border-2 border-dashed border-slate-200 rounded-lg p-3 hover:border-gold transition">
                                        <input type="file" id="bil_eletrik" name="bil_eletrik" class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <button type="submit" class="w-full bg-gold hover:bg-gold-dark text-navy-dark font-bold py-4 px-4 rounded-xl shadow-sm transition text-sm tracking-wide">
                        Hantar Permohonan Sekarang
                    </button>
                    <p class="text-center text-[10px] text-slate-400">
                        Dengan menghantar borang ini, anda bersetuju dengan <a href="#" class="text-navy underline">Dasar Privasi</a> kami.
                    </p>
                </form>
            </div>

            <div class="mt-6 flex flex-wrap justify-center gap-6 text-sm text-slate-500">
                <a href="mailto:hello@rahmahconsulting.com" class="flex items-center gap-2 hover:text-navy transition">
                    <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/></svg>
                    hello@rahmahconsulting.com
                </a>
                <a href="tel:+60123456789" class="flex items-center gap-2 hover:text-navy transition">
                    <svg class="w-4 h-4 text-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                    +60 12-345 6789
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
    </script>

@endsection
