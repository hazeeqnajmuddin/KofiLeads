@extends('layouts.main')

@section('title', 'Home - Rahmah Consultancy Services (RCS)')

@section('content')
    <!-- 1. Hero / Title Section -->
    <section class="bg-gray-50 py-20 px-4 sm:px-6 lg:px-8 text-center font-sans">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif font-bold tracking-tight text-brand-navy mb-6 leading-tight">
                Semak Kelayakan Anda Bersama <br> <span class="text-brand-gold">Rahmah Consultancy Services</span>
            </h1>
            <p class="text-lg text-brand-gray mb-10 leading-relaxed max-w-3xl mx-auto">
                Rahmah Consultancy Services atau RCS membantu pelanggan mendapatkan solusi kewangan melalui khidmat semakan kelayakan, penyatuan hutang dan pembiayaan peribadi bank serta koperasi. Fokus utama RCS adalah membantu pelanggan memahami kedudukan kewangan mereka dengan lebih jelas sebelum membuat keputusan pembiayaan. Kami turut membantu pelanggan yang mempunyai isu CCRIS, CTOS, AKPK, SAA, tindakan undang-undang, komitmen tinggi dan rekod kewangan yang memerlukan semakan lanjut. Pendekatan kami adalah berasaskan konsultasi, ketelusan dan bayaran hanya apabila permohonan berjaya diluluskan.
            </p>
            <a href="#contact" class="inline-block bg-brand-gold text-white font-bold px-8 py-4 rounded shadow-md hover:bg-brand-gold/90 transition-colors duration-200 text-lg uppercase tracking-wide">
                Semak Kelayakan Sekarang!
            </a>
        </div>
    </section>

    <!-- 2. Our Services -->
    <section id="services" class="py-20 px-4 bg-white font-sans">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-serif font-bold text-center text-brand-navy mb-16">Servis Kami</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                
                <!-- Service Card 1 -->
                <div class="p-8 bg-white rounded-xl shadow-lg border-t-4 border-brand-gold hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-14 h-14 bg-brand-navy/5 text-brand-gold rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-serif font-semibold text-brand-navy mb-3">Semakan Kewangan</h3>
                    <p class="text-brand-gray leading-relaxed">Semakan awal pantas secara online atau WhatsApp berdasarkan dokumen pelanggan, kelayakan semasa dan polisi institusi kewangan yang berkaitan.</p>
                </div>

                <!-- Service Card 2 -->
                <div class="p-8 bg-white rounded-xl shadow-lg border-t-4 border-brand-navy hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-14 h-14 bg-brand-navy/5 text-brand-navy rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-serif font-semibold text-brand-navy mb-3">Pembiayaan Peribadi</h3>
                    <p class="text-brand-gray leading-relaxed">Fokus eksklusif kepada pembiayaan peribadi bank dan koperasi untuk pekerja sektor kerajaan, GLC, badan berkanun dan swasta.</p>
                </div>

                <!-- Service Card 3 -->
                <div class="p-8 bg-white rounded-xl shadow-lg border-t-4 border-brand-gold hover:-translate-y-1 transition-transform duration-300">
                    <div class="w-14 h-14 bg-brand-navy/5 text-brand-gold rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-serif font-semibold text-brand-navy mb-3">Penyatuan Hutang</h3>
                    <p class="text-brand-gray leading-relaxed">Berpengalaman luas mengendalikan pelbagai kes rumit termasuk CCRIS, CTOS, AKPK, SAA, tindakan undang-undang dan komitmen kewangan yang tinggi.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- 3. Stats and Facts -->
    <section id="stats" class="py-20 px-4 bg-brand-navy text-white text-center font-sans border-y-4 border-brand-gold">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10">
                
                <div class="flex flex-col">
                    <span class="text-5xl font-serif font-bold text-brand-gold mb-3">10k+</span>
                    <span class="text-gray-300 uppercase tracking-wider text-sm font-semibold">Individu Dibantu</span>
                </div>
                
                <div class="flex flex-col">
                    <span class="text-5xl font-serif font-bold text-brand-gold mb-3">4</span>
                    <span class="text-gray-300 uppercase tracking-wider text-sm font-semibold">Sektor Utama</span>
                </div>
                
                <div class="flex flex-col">
                    <span class="text-5xl font-serif font-bold text-brand-gold mb-3">100%</span>
                    <span class="text-gray-300 uppercase tracking-wider text-sm font-semibold">Semakan Online</span>
                </div>
                
                <div class="flex flex-col">
                    <span class="text-5xl font-serif font-bold text-brand-gold mb-3">Telus</span>
                    <span class="text-gray-300 uppercase tracking-wider text-sm font-semibold">Proses Penilaian</span>
                </div>

            </div>
        </div>
    </section>

    <!-- 4. Customers / Testimony -->
    <section class="py-20 px-4 bg-gray-50 font-sans">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-4xl font-serif font-bold text-brand-navy mb-16">Apa Kata Mereka?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Testimoni 1 -->
                <div class="flex flex-col h-full">
                    <div class="bg-white p-10 rounded-xl shadow-sm italic text-brand-gray mb-6 border border-gray-100 flex-grow relative">
                        <span class="text-5xl text-brand-gold/20 absolute top-4 left-4 font-serif">"</span>
                        <p class="relative z-10 pt-4">Alhamdulillah, pelanggan berjaya mendapatkan solusi penyatuan hutang selepas semakan kelayakan dibuat secara teratur.</p>
                    </div>
                    <div class="font-bold text-brand-navy uppercase tracking-wide text-sm">- Pelanggan 1</div>
                </div>

                <!-- Testimoni 2 -->
                <div class="flex flex-col h-full">
                    <div class="bg-white p-10 rounded-xl shadow-sm italic text-brand-gray mb-6 border border-gray-100 flex-grow relative">
                        <span class="text-5xl text-brand-gold/20 absolute top-4 left-4 font-serif">"</span>
                        <p class="relative z-10 pt-4">Pelanggan lebih jelas tentang komitmen bulanan dan pilihan pembiayaan yang sesuai selepas sesi konsultasi.</p>
                    </div>
                    <div class="font-bold text-brand-navy uppercase tracking-wide text-sm">- Pelanggan 2</div>
                </div>

                <!-- Testimoni 3 -->
                <div class="flex flex-col h-full">
                    <div class="bg-white p-10 rounded-xl shadow-sm italic text-brand-gray mb-6 border border-gray-100 flex-grow relative">
                        <span class="text-5xl text-brand-gold/20 absolute top-4 left-4 font-serif">"</span>
                        <p class="relative z-10 pt-4">Proses semakan dibantu daripada peringkat dokumen sehingga permohonan dihantar kepada pihak berkaitan.</p>
                    </div>
                    <div class="font-bold text-brand-navy uppercase tracking-wide text-sm">- Pelanggan 3</div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. FAQs -->
    <section id="faqs" class="py-20 px-4 bg-white font-sans">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-4xl font-serif font-bold text-center text-brand-navy mb-12">Soalan Lazim</h2>
            <div class="space-y-6">
                
                <details class="group bg-gray-50 p-8 rounded-lg border border-gray-100 hover:border-brand-gold/50 transition-colors duration-200 cursor-pointer">
                    <summary class="font-serif font-semibold text-xl text-brand-navy list-none flex justify-between items-center outline-none">
                        Apakah servis utama RCS?
                        <span class="transition-transform duration-200 group-open:rotate-180">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-brand-gray leading-relaxed mt-4">RCS menyediakan khidmat konsultasi kewangan, semakan kelayakan pembiayaan peribadi, penyatuan hutang dan panduan berkaitan isu CCRIS, CTOS, AKPK, SAA, legal action serta komitmen kewangan.</p>
                </details>
                
                <details class="group bg-gray-50 p-8 rounded-lg border border-gray-100 hover:border-brand-gold/50 transition-colors duration-200 cursor-pointer">
                    <summary class="font-serif font-semibold text-xl text-brand-navy list-none flex justify-between items-center outline-none">
                        Siapa yang boleh membuat semakan?
                        <span class="transition-transform duration-200 group-open:rotate-180">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-brand-gray leading-relaxed mt-4">Semakan terbuka kepada kakitangan kerajaan, GLC, badan berkanun dan pekerja swasta yang mempunyai pendapatan tetap serta dokumen sokongan yang lengkap.</p>
                </details>
                
                <details class="group bg-gray-50 p-8 rounded-lg border border-gray-100 hover:border-brand-gold/50 transition-colors duration-200 cursor-pointer">
                    <summary class="font-serif font-semibold text-xl text-brand-navy list-none flex justify-between items-center outline-none">
                        Apakah kelayakan asas untuk semakan awal?
                        <span class="transition-transform duration-200 group-open:rotate-180">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-brand-gray leading-relaxed mt-4">
                        Kelayakan asas adalah seperti berikut:<br><br>
                        <span class="font-semibold text-brand-navy">&bull; Kerajaan:</span> Gaji asas minimum RM1,500<br>
                        <span class="font-semibold text-brand-navy">&bull; GLC / Badan Berkanun:</span> Gaji asas minimum RM2,500<br>
                        <span class="font-semibold text-brand-navy">&bull; Swasta:</span> Gaji asas minimum RM3,000<br><br>
                        Namun, kelayakan sebenar masih bergantung kepada dokumen, rekod kewangan dan polisi bank / koperasi.
                    </p>
                </details>
                
                <details class="group bg-gray-50 p-8 rounded-lg border border-gray-100 hover:border-brand-gold/50 transition-colors duration-200 cursor-pointer">
                    <summary class="font-serif font-semibold text-xl text-brand-navy list-none flex justify-between items-center outline-none">
                        Adakah perlu bayar dahulu sebelum semakan dibuat?
                        <span class="transition-transform duration-200 group-open:rotate-180">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-brand-gray leading-relaxed mt-4">Tidak. RCS mengamalkan konsep bayaran hanya apabila permohonan berjaya diluluskan, tertakluk kepada terma perkhidmatan.</p>
                </details>
                
                <details class="group bg-gray-50 p-8 rounded-lg border border-gray-100 hover:border-brand-gold/50 transition-colors duration-200 cursor-pointer">
                    <summary class="font-serif font-semibold text-xl text-brand-navy list-none flex justify-between items-center outline-none">
                        Bolehkah pelanggan yang ada CCRIS, CTOS, AKPK, SAA atau legal action membuat semakan?
                        <span class="transition-transform duration-200 group-open:rotate-180">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-brand-gray leading-relaxed mt-4">Boleh. Namun kelayakan bergantung kepada tahap rekod kewangan, jenis isu, dokumen sokongan, status pekerjaan dan polisi pihak bank / koperasi.</p>
                </details>

                <details class="group bg-gray-50 p-8 rounded-lg border border-gray-100 hover:border-brand-gold/50 transition-colors duration-200 cursor-pointer">
                    <summary class="font-serif font-semibold text-xl text-brand-navy list-none flex justify-between items-center outline-none">
                        Adakah RCS menjamin kelulusan pinjaman?
                        <span class="transition-transform duration-200 group-open:rotate-180">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-brand-gray leading-relaxed mt-4">Tidak. Kelulusan adalah tertakluk sepenuhnya kepada penilaian pihak bank atau koperasi. RCS membantu dari segi semakan awal, konsultasi, penyusunan dokumen dan cadangan solusi yang bersesuaian.</p>
                </details>

                <details class="group bg-gray-50 p-8 rounded-lg border border-gray-100 hover:border-brand-gold/50 transition-colors duration-200 cursor-pointer">
                    <summary class="font-serif font-semibold text-xl text-brand-navy list-none flex justify-between items-center outline-none">
                        Berapa lama proses permohonan?
                        <span class="transition-transform duration-200 group-open:rotate-180">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-brand-gray leading-relaxed mt-4">Tempoh proses bergantung kepada kelengkapan dokumen, jenis produk pembiayaan, polisi institusi kewangan dan keadaan rekod pelanggan.</p>
                </details>

                <details class="group bg-gray-50 p-8 rounded-lg border border-gray-100 hover:border-brand-gold/50 transition-colors duration-200 cursor-pointer">
                    <summary class="font-serif font-semibold text-xl text-brand-navy list-none flex justify-between items-center outline-none">
                        Adakah maklumat pelanggan dirahsiakan?
                        <span class="transition-transform duration-200 group-open:rotate-180">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </span>
                    </summary>
                    <p class="text-brand-gray leading-relaxed mt-4">Ya. Semua maklumat dan dokumen pelanggan digunakan hanya untuk tujuan semakan dan permohonan berkaitan, tertakluk kepada persetujuan pelanggan.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- 6. Form & Contact -->
    <section id="contact" class="py-20 px-4 bg-gray-50 border-t border-gray-200 font-sans">
        <div class="max-w-2xl mx-auto bg-white p-10 rounded-2xl shadow-xl border-t-8 border-brand-navy">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-serif font-bold text-brand-navy mb-4">Semak Kelayakan Sekarang</h2>
                <p class="text-brand-gray">Isi maklumat ringkas & upload dokumen untuk semakan awal.</p>
            </div>
            
            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama" class="block text-sm font-bold text-brand-navy mb-2">Nama Penuh</label>
                        <input type="text" id="nama" name="nama" class="w-full rounded bg-gray-50 border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-3 border transition-colors" required>
                    </div>

                    <div>
                        <label for="no_tele" class="block text-sm font-bold text-brand-navy mb-2">No Telefon / WhatsApp</label>
                        <input type="tel" id="no_tele" name="no_tele" class="w-full rounded bg-gray-50 border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-3 border transition-colors" required>
                    </div>
                </div>

                <div>
                    <label for="alamat_emel" class="block text-sm font-bold text-brand-navy mb-2">Alamat Emel</label>
                    <input type="email" id="alamat_emel" name="alamat_emel" class="w-full rounded bg-gray-50 border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-3 border transition-colors">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="daerah" class="block text-sm font-bold text-brand-navy mb-2">Daerah</label>
                        <input type="text" id="daerah" name="daerah" class="w-full rounded bg-gray-50 border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-3 border transition-colors">
                    </div>

                    <div>
                        <label for="Poskod" class="block text-sm font-bold text-brand-navy mb-2">Poskod</label>
                        <input type="text" id="Poskod" name="Poskod" class="w-full rounded bg-gray-50 border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-3 border transition-colors">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="sektor_pekerjaan" class="block text-sm font-bold text-brand-navy mb-2">Sektor Pekerjaan</label>
                        <select id="sektor_pekerjaan" name="sektor_pekerjaan" class="w-full rounded bg-gray-50 border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-3 border transition-colors" required>
                            <option value="">Sila pilih...</option>
                            <option value="swasta">Swasta</option>
                            <option value="kerajaan">Kerajaan</option>
                            <option value="glc">GLC</option>
                            <option value="badan_berkanun">Badan Berkanun</option>
                        </select>
                    </div>

                    <div>
                        <label for="status_pekerjaan" class="block text-sm font-bold text-brand-navy mb-2">Status Pekerjaan</label>
                        <select id="status_pekerjaan" name="status_pekerjaan" class="w-full rounded bg-gray-50 border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-3 border transition-colors" required>
                            <option value="">Sila pilih...</option>
                            <option value="tetap">Tetap</option>
                            <option value="kontrak">Kontrak</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nama_majikan" class="block text-sm font-bold text-brand-navy mb-2">Nama Majikan</label>
                        <input type="text" id="nama_majikan" name="nama_majikan" class="w-full rounded bg-gray-50 border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-3 border transition-colors">
                    </div>

                    <div>
                        <label for="jawatan" class="block text-sm font-bold text-brand-navy mb-2">Jawatan</label>
                        <input type="text" id="jawatan" name="jawatan" class="w-full rounded bg-gray-50 border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-3 border transition-colors">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="gaji_asas" class="block text-sm font-bold text-brand-navy mb-2">Gaji Asas (RM)</label>
                        <input type="text" id="gaji_asas" name="gaji_asas" class="w-full rounded bg-gray-50 border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-3 border transition-colors">
                    </div>

                    <div>
                        <label for="masalah_utama" class="block text-sm font-bold text-brand-navy mb-2">Masalah Utama</label>
                        <select id="masalah_utama" name="masalah_utama" class="w-full rounded bg-gray-50 border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-3 border transition-colors" required>
                            <option value="">Sila pilih...</option>
                            <option value="Komitmen_tinggi">Komitmen Tinggi</option>
                            <option value="CCRIS">CCRIS</option>
                            <option value="CTOS">CTOS</option>
                            <option value="AKPK">AKPK</option>
                            <option value="SAA">SAA</option>
                            <option value="Legal Action">Legal Action</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>
                </div>

                <hr class="border-gray-200 my-8">

                <div class="space-y-5">
                    <h3 class="font-serif font-bold text-brand-navy text-lg border-b pb-2">Muat Naik Dokumen</h3>
                    
                    <div>
                        <label for="slip_gaji" class="block text-sm font-bold text-brand-navy mb-2">Slip Gaji 3 Bulan Terkini</label>
                        <input type="file" id="slip_gaji" name="slip_gaji" multiple class="w-full rounded border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-1 border file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-brand-navy/10 file:text-brand-navy hover:file:bg-brand-navy/20 cursor-pointer" required>
                    </div>

                    <div>
                        <label for="ctos_report" class="block text-sm font-bold text-brand-navy mb-2">CTOS Report Terkini</label>
                        <input type="file" id="ctos_report" name="ctos_report" class="w-full rounded border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-1 border file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-brand-navy/10 file:text-brand-navy hover:file:bg-brand-navy/20 cursor-pointer" required>
                    </div>

                    <div>
                        <label for="epf_statement" class="block text-sm font-bold text-brand-navy mb-2">Penyata EPF 2 Tahun Terkini <span class="text-xs font-normal text-brand-gray block mt-1">(Untuk pekerja swasta sahaja)</span></label>
                        <input type="file" id="epf_statement" name="epf_statement" class="w-full rounded border-gray-300 focus:border-brand-gold focus:ring-brand-gold p-1 border file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-brand-navy/10 file:text-brand-navy hover:file:bg-brand-navy/20 cursor-pointer" required>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-brand-navy text-white font-bold py-4 px-6 rounded shadow-md hover:bg-brand-navy/90 transition-colors duration-200 text-lg uppercase tracking-wide">
                        Hantar Permohonan Semakan
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection