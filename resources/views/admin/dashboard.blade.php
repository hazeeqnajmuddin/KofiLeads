@extends('layouts.admin')

@section('title', 'Utama Pentadbir - Rahmah Consulting')

@section('admin_content')
<div class="space-y-8">
    
    <!-- Title / Headline Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-200">
        <div>
            <h1 class="text-2xl font-bold text-slate-950 tracking-tight">Ringkasan Pengurusan</h1>
            <p class="text-sm text-slate-500">Pantau kemasukan pelanggan dan kemas kini tetapan iklan pemasaran.</p>
        </div>
        
        <!-- Only 1 KPI Counter Retained -->
        <div class="bg-white px-5 py-3 rounded-xl shadow-xs border border-slate-200/60 flex items-center space-x-4 self-start sm:self-auto">
            <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
            <div>
                <div class="text-slate-400 text-[10px] font-semibold uppercase tracking-wider">Dihantar ke WhatsApp</div>
                <div class="text-2xl font-extrabold text-slate-900 tracking-tight">294</div>
            </div>
        </div>
    </div>

    <!-- SECTION 1: Senarai Prospek Masuk dengan Fungsi Tapisan (Filters) -->
    <section id="senarai-prospek" class="bg-white rounded-xl shadow-xs border border-slate-200/80 overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-slate-100 bg-slate-50/50 space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-base font-bold text-slate-900">Senarai Permohonan Pelanggan</h2>
            </div>
            
            <!-- Filter Input Fields Row -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Cari Melalui Nama</label>
                    <input type="text" id="filter-nama" onkeyup="tapisProspek()" placeholder="Taip nama prospek..." class="w-full text-xs rounded-lg border-slate-200 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border transition">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Tapis Mengikut Pekerjaan</label>
                    <input type="text" id="filter-pekerjaan" onkeyup="tapisProspek()" placeholder="Contoh: CEO, Guru, Kerani..." class="w-full text-xs rounded-lg border-slate-200 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 p-2.5 border transition">
                </div>
            </div>
        </div>
        
        <!-- Table Box Layer -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[650px]" id="jadual-prospek">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="p-4">Nama Pelanggan</th>
                        <th class="p-4">No. Telefon</th>
                        <th class="p-4">Pekerjaan</th>
                        <th class="p-4 text-center">Dokumen</th>
                        <th class="p-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="text-xs sm:text-sm divide-y divide-slate-100 text-slate-700">
                    <tr class="prospek-row">
                        <td class="p-4 font-semibold text-slate-900 target-nama">Ahmad Albab</td>
                        <td class="p-4 text-slate-600">+60 12-345 6789</td>
                        <td class="p-4 target-kerja">CEO</td>
                        <td class="p-4 text-center">
                            <a href="#" class="inline-flex items-center space-x-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-medium px-2.5 py-1.5 rounded-md text-xs border border-rose-200/40 transition">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                <span>Muat Turun PDF</span>
                            </a>
                        </td>
                        <td class="p-4 text-right">
                            <button onclick="bukaModal('Ahmad Albab', '35', '+60 12-345 6789', 'ahmad@pistachio.com', 'CEO', 'Makanan / Snek', 'tidak')" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs bg-indigo-50 px-2.5 py-1.5 rounded transition">Lihat Butiran</button>
                        </td>
                    </tr>
                    <tr class="prospek-row">
                        <td class="p-4 font-semibold text-slate-900 target-nama">Siti Nurdiana</td>
                        <td class="p-4 text-slate-600">+60 17-987 6543</td>
                        <td class="p-4 target-kerja">Pensyarah</td>
                        <td class="p-4 text-center">
                            <a href="#" class="inline-flex items-center space-x-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 font-medium px-2.5 py-1.5 rounded-md text-xs border border-rose-200/40 transition">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                <span>Muat Turun PDF</span>
                            </a>
                        </td>
                        <td class="p-4 text-right">
                            <button onclick="bukaModal('Siti Nurdiana', '29', '+60 17-987 6543', 'siti@edu.my', 'Pensyarah', 'Pendidikan', 'ya')" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs bg-indigo-50 px-2.5 py-1.5 rounded transition">Lihat Butiran</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <!-- SECTION 2: Pengurusan Kandungan Landing Page (Split Dynamic Modules) -->
    <div id="pengurusan-landing" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- MODULE A: Urus Video Ads Kreatif -->
        <div class="bg-white rounded-xl shadow-xs border border-slate-200/80 overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-900 text-sm sm:text-base">Kemaskini Video Iklan</h3>
                <p class="text-xs text-slate-400">Muat naik fail video promosi baru untuk dipaparkan di bahagian utama.</p>
            </div>
            <div class="p-5">
                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="border-2 border-dashed border-slate-200 rounded-lg p-4 text-center bg-slate-50">
                        <svg class="mx-auto h-8 w-8 text-slate-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <input type="file" name="video_ads" accept="video/*" class="text-xs text-slate-600 block w-full mx-auto file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 text-xs rounded-md shadow-xs transition">
                        Muat Naik
                    </button>
                </form>
            </div>
        </div>

        <!-- MODULE B: Urus No Telefon WhatsApp Integrasi -->
        <div class="bg-white rounded-xl shadow-xs border border-slate-200/80 overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-900 text-sm sm:text-base">Nombor WhatsApp</h3>
                <p class="text-xs text-slate-400">Tukar nombor penerimaan mesej semakan kelayakan.</p>
            </div>
            <div class="p-5">
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">No. Telefon WhatsApp Berserta Kod Negara</label>
                        <input type="tel" name="whatsapp_phone" value="+60123456789" placeholder="Contoh: +60123456789" class="w-full rounded-md border-slate-300 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 p-2 border text-xs sm:text-sm">
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 text-xs rounded-md shadow-xs transition">
                        Simpan
                    </button>
                </form>
            </div>
        </div>
        
    </div>
</div>

<!-- Modal Details Component -->
<div id="modal-butiran" class="fixed inset-0 z-50 bg-slate-950/50 backdrop-blur-xs hidden flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white w-full max-w-lg rounded-xl shadow-xl overflow-hidden border border-slate-200 my-auto max-h-[90vh] flex flex-col">
        <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-white sticky top-0">
            <h3 class="font-bold text-slate-900 text-sm sm:text-base">Maklumat Lengkap Prospek</h3>
            <button onclick="tutupModal()" class="text-slate-400 hover:text-slate-600 text-2xl font-light focus:outline-hidden">&times;</button>
        </div>
        <div class="p-4 space-y-4 text-xs sm:text-sm overflow-y-auto flex-1">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><span class="block text-[10px] font-semibold text-slate-400 uppercase">Nama Penuh</span><p id="p-nama" class="text-slate-900 font-semibold mt-0.5"></p></div>
                <div><span class="block text-[10px] font-semibold text-slate-400 uppercase">Umur</span><p id="p-umur" class="text-slate-900 mt-0.5"></p></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><span class="block text-[10px] font-semibold text-slate-400 uppercase">No. Telefon</span><p id="p-tele" class="text-slate-900 font-medium mt-0.5"></p></div>
                <div><span class="block text-[10px] font-semibold text-slate-400 uppercase">Alamat Emel</span><p id="p-emel" class="text-indigo-600 font-medium mt-0.5 break-all"></p></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t border-slate-100 pt-3">
                <div><span class="block text-[10px] font-semibold text-slate-400 uppercase">Pekerjaan</span><p id="p-kerja" class="text-slate-900 mt-0.5"></p></div>
                <div><span class="block text-[10px] font-semibold text-slate-400 uppercase">Industri</span><p id="p-industri" class="text-slate-900 mt-0.5"></p></div>
            </div>
            <div class="border-t border-slate-100 pt-3">
                <span class="block text-[10px] font-semibold text-slate-400 uppercase">Kakitangan Kerajaan?</span>
                <p id="p-gov" class="mt-0.5 capitalize font-medium"></p>
            </div>
        </div>
        <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end sticky bottom-0">
            <button onclick="tutupModal()" class="w-full sm:w-auto text-center px-4 py-2 text-xs font-medium text-slate-700 bg-white border border-slate-300 rounded-lg shadow-xs hover:bg-slate-50 transition">Tutup</button>
        </div>
    </div>
</div>

<!-- JavaScript Filtering Engine & Modal Handlers -->
<script>
    function tapisProspek() {
        let inputNama = document.getElementById('filter-nama').value.toLowerCase();
        let inputKerja = document.getElementById('filter-pekerjaan').value.toLowerCase();
        let rows = document.getElementsByClassName('prospek-row');

        for (let i = 0; i < rows.length; i++) {
            let namaCol = rows[i].getElementsByClassName('target-nama')[0].innerText.toLowerCase();
            let kerjaCol = rows[i].getElementsByClassName('target-kerja')[0].innerText.toLowerCase();
            
            if (namaCol.includes(inputNama) && kerjaCol.includes(inputKerja)) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }

    function bukaModal(nama, umur, tele, emel, kerja, industri, gov) {
        document.getElementById('p-nama').innerText = nama || '-';
        document.getElementById('p-umur').innerText = umur ? umur + ' Tahun' : 'Tidak Dinyatakan';
        document.getElementById('p-tele').innerText = tele || '-';
        document.getElementById('p-emel').innerText = emel || '-';
        document.getElementById('p-kerja').innerText = kerja || '-';
        document.getElementById('p-industri').innerText = industri || 'Tidak Dinyatakan';
        document.getElementById('p-gov').innerText = gov === 'ya' ? 'Ya (Kakitangan Awam)' : 'Tidak';
        document.getElementById('modal-butiran').classList.remove('hidden');
    }

    function tutupModal() {
        document.getElementById('modal-butiran').classList.add('hidden');
    }
</script>
@endsection