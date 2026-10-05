<head>
    <title>{{ \App\Models\Setting::get('site_title', 'KofiLeads') }}</title>
    <meta name="description" content="Semak Kelayakan & Pengurusan Lead Sales">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite('resources/css/app.css')
</head>

<div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4 sm:p-6">
    
    <div class="w-full max-w-2xl bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col font-sans" role="dialog" aria-modal="true">
        
        <div class="bg-brand-navy px-6 py-5">
            <h2 class="text-white font-serif text-2xl font-bold tracking-wide">
                Pengesahan & Persetujuan
            </h2>
            <p class="text-brand-gold text-xs text-spacing-wide uppercase mt-1.5 font-semibold">
                {{ \App\Models\Setting::get('site_title', 'KofiLeads') }}
            </p>
        </div>

        <div class="px-6 py-6 overflow-y-auto max-h-[70vh]">
            
            <p class="text-brand-gray text-sm md:text-base leading-relaxed mb-8 text-justify">
                Saya mengesahkan bahawa semua maklumat dan dokumen yang diberikan adalah benar. Saya bersetuju membenarkan <span class="font-semibold text-brand-navy">pihak pengurusan</span> mengumpul, menyimpan, memproses dan berkongsi maklumat saya kepada bank, koperasi, institusi kewangan, banker, panel atau rakan strategik berkaitan bagi tujuan semakan kelayakan, penyatuan hutang, permohonan pembiayaan, pemulihan rekod dan susulan kes. Saya faham bahawa semakan ini tidak menjamin kelulusan.
            </p>

            <form id="acknowledgement-form" class="space-y-8">
                
                <div class="space-y-4">
                    <h3 class="font-semibold text-brand-navy text-sm border-b border-gray-200 pb-2 mb-4 uppercase tracking-wider">
                        Keperluan Wajib
                    </h3>

                    <label class="flex items-start gap-3 cursor-pointer group">
                        <div class="flex-shrink-0 mt-0.5">
                            <input type="checkbox" required 
                                class="w-5 h-5 rounded border-gray-300 accent-brand-gold cursor-pointer">
                        </div>
                        <span class="text-sm text-brand-gray group-hover:text-brand-navy transition-colors duration-200">
                            Saya telah membaca, memahami dan bersetuju dengan <a href="https://www.pdp.gov.my/ppdpv1/en/akta/pdp-act-2010-en/" target="_blank" rel="noopener noreferrer" class="text-brand-navy underline">Notis Perlindungan Data Peribadi</a>.
                        </span>
                    </label>

                    <label class="flex items-start gap-3 cursor-pointer group">
                        <div class="flex-shrink-0 mt-0.5">
                            <input type="checkbox" required 
                                class="w-5 h-5 rounded border-gray-300 accent-brand-gold cursor-pointer">
                        </div>
                        <span class="text-sm text-brand-gray group-hover:text-brand-navy transition-colors duration-200">
                            Saya bersetuju untuk dihubungi melalui WhatsApp/telefon/emel bagi tujuan semakan dan susulan kes.
                        </span>
                    </label>
                </div>

                <div class="space-y-4">
                    <h3 class="font-semibold text-brand-navy text-sm border-b border-gray-200 pb-2 mb-4 uppercase tracking-wider">
                        Pilihan Pemasaran
                    </h3>

                    <label class="flex items-start gap-3 cursor-pointer group">
                        <div class="flex-shrink-0 mt-0.5">
                            <input type="checkbox" 
                                class="w-5 h-5 rounded border-gray-300 accent-brand-gold cursor-pointer">
                        </div>
                        <span class="text-sm text-brand-gray group-hover:text-brand-navy transition-colors duration-200">
                            Saya bersetuju menerima maklumat promosi/pendidikan kewangan.
                        </span>
                    </label>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 border-t border-gray-100">
            <button type="button" class="px-5 py-2.5 rounded-lg text-sm font-medium text-brand-gray bg-white border border-gray-300 hover:bg-gray-100 transition-colors duration-200">
                Batal
            </button>
            <button type="button" class="px-6 py-2.5 rounded-lg text-sm font-medium text-white bg-gold-gradient hover:opacity-90 transition-opacity duration-200 shadow-md">
                Saya Setuju & Hantar
            </button>
        </div>
        
    </div>
</div>