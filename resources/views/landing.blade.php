@extends('layouts.main')

@section('title', 'Home - AppLogo')

@section('content')
    <!-- 1. Hero / Title Section -->
    <section class="bg-indigo-50 py-20 px-4 sm:px-6 lg:px-8 text-center">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl mb-6">
                Semak Kelayakan Anda Bersama Rahmah Consulting
            </h1>
            <p class="text-lg text-slate-600 mb-8">
                Penyelesaian inovatif untuk keperluan perniagaan anda. Sertai ribuan pengguna yang telah mempercayai kami untuk membina masa depan mereka.
            </p>
            <a href="#contact" class="inline-block bg-indigo-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-indigo-700 transition">
                Semak Kelayakan Sekarang!
            </a>
        </div>
    </section>

    <!-- 2. Our Services -->
    <section id="services" class="py-16 px-4 bg-white">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-12">Servis Kami</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service Card -->
                <div class="p-6 bg-slate-50 rounded-xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mb-4">
                        <!-- Placeholder Icon -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Servis Pertama</h3>
                    <p class="text-slate-600 text-sm">Servis pertama yang disediakan oleh kami.</p>
                </div>
                <div class="p-6 bg-slate-50 rounded-xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mb-4">
                        <!-- Placeholder Icon -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Servis Kedua</h3>
                    <p class="text-slate-600 text-sm">Servis berkualiti tinggi yang disesuaikan untuk keperluan mudah alih anda.</p>
                </div>
                <div class="p-6 bg-slate-50 rounded-xl shadow-sm border border-slate-100">
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center mb-4">
                        <!-- Placeholder Icon -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Servis Ketiga</h3>
                    <p class="text-slate-600 text-sm">Servis ketiga yang disediakan oleh kami.</p>
                </div>
                <!-- Duplicate cards for more services... -->
            </div>
        </div>
    </section>

    <!-- 3. Stats and Facts -->
    <section id="stats" class="py-16 px-4 bg-indigo-600 text-white text-center">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="flex flex-col">
                    <span class="text-4xl font-extrabold mb-2">10k+</span>
                    <span class="text-indigo-200 text-sm">Pelanggan</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-4xl font-extrabold mb-2">91%</span>
                    <span class="text-indigo-200 text-sm">Peratus Kepuasan Pelanggan</span>
                </div>
                <!-- Add more stats as needed -->
            </div>
        </div>
    </section>

    <!-- 4. Customers / Testimony -->
    <section class="py-16 px-4 bg-white">
        <div class="max-w-md mx-auto md:max-w-4xl text-center">
            <h2 class="text-3xl font-bold mb-10">Apa Kata Mereka?</h2>
            <div class="bg-slate-50 p-8 rounded-2xl shadow-sm italic text-slate-700 mb-6 border border-slate-100">
                "Servis yang hebat! Membantu saya dalam menyelesaikan masalah dengan cepat dan efisien."
            </div>
            <div class="font-semibold text-slate-900">- Ahmad Albab, CEO of Karipap Pistachio</div>
        </div>
    </section>

    <!-- 5. FAQs -->
    <section id="faqs" class="py-16 px-4 bg-slate-50">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-10">Soalan Lazim</h2>
            <div class="space-y-4">
                <!-- FAQ Item (Static UI for now) -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
                    <h3 class="font-semibold text-lg mb-2">Bagaimana kelayakan disemak?</h3>
                    <p class="text-slate-600 text-sm">Kelayakan akan disemak berdasarkan kriteria yang ditetapkan oleh pihak kami.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Form & Contact (Combined) -->
    <section id="contact" class="py-16 px-4 bg-white border-t border-slate-100">
        <div class="max-w-xl mx-auto">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold mb-4">Semak Kelayakan Sekarang!</h2>
                <p class="text-slate-600 text-sm">Email: hello@rahmahconsulting.com | Phone: +60 12-345 6789</p>
            </div>
            
            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <div>
        <label for="nama" class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
        <input type="text" id="nama" name="nama" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" required>
    </div>

    <div>
        <label for="umur" class="block text-sm font-medium text-slate-700 mb-1">
            Umur <span class="text-xs font-normal text-slate-400">(Pilihan)</span>
        </label>
        <input type="number" id="umur" name="umur" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
    </div>

    <div>
        <label for="no_tele" class="block text-sm font-medium text-slate-700 mb-1">No Telefon</label>
        <input type="tel" id="no_tele" name="no_tele" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" required>
    </div>

    <div>
        <label for="alamat_emel" class="block text-sm font-medium text-slate-700 mb-1">Alamat Emel</label>
        <input type="email" id="alamat_emel" name="alamat_emel" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" required>
    </div>

    <div>
        <label for="pekerjaan" class="block text-sm font-medium text-slate-700 mb-1">Pekerjaan</label>
        <input type="text" id="pekerjaan" name="pekerjaan" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border" required>
    </div>

    <div>
        <label for="industri_pekerjaan" class="block text-sm font-medium text-slate-700 mb-1">
            Industri Pekerjaan <span class="text-xs font-normal text-slate-400">(Pilihan)</span>
        </label>
        <input type="text" id="industri_pekerjaan" name="industri_pekerjaan" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
    </div>

    <div>
        <label for="kakitangan_kerajaan" class="block text-sm font-medium text-slate-700 mb-1">Kakitangan Kerajaan</label>
        <select id="kakitangan_kerajaan" name="kakitangan_kerajaan" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border bg-white" required>
            <option value="">Sila pilih...</option>
            <option value="ya">Ya</option>
            <option value="tidak">Tidak</option>
        </select>
    </div>

    <div>
        <label for="dokumen_pengenalan" class="block text-sm font-medium text-slate-700 mb-1">Dokumen Pengenalan</label>
        <input type="file" id="dokumen_pengenalan" name="dokumen_pengenalan" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-1.5 border file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
    </div>

    <div>
        <label for="slip_gaji" class="block text-sm font-medium text-slate-700 mb-1">Slip Gaji 3 Bulan Terkini</label>
        <input type="file" id="slip_gaji" name="slip_gaji" multiple class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-1.5 border file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" required>
    </div>

    <div>
        <label for="ctos_report" class="block text-sm font-medium text-slate-700 mb-1">
            Laporan CTOS <span class="text-xs font-normal text-slate-400">(Pilihan)</span>
        </label>
        <input type="file" id="ctos_report" name="ctos_report" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-1.5 border file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
    </div>

    <div>
        <label for="bil_eletrik" class="block text-sm font-medium text-slate-700 mb-1">
            Bil Elektrik <span class="text-xs font-normal text-slate-400">(Pilihan)</span>
        </label>
        <input type="file" id="bil_eletrik" name="bil_eletrik" class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-1.5 border file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
    </div>

    <button type="submit" class="w-full bg-indigo-600 text-white font-semibold py-3 px-4 rounded-md shadow-sm hover:bg-indigo-700 transition">
        Semak Kelayakan Sekarang!
    </button>
</form>
            </form>
        </div>
    </section>
@endsection