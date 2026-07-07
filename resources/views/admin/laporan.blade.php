@extends('layouts.admin')

@section('title', 'Laporan')
@section('page_title', 'Laporan')
@section('page_subtitle', 'Analisis dan pecahan data permohonan')

@section('admin_content')

<!-- Filter toolbar (server-side GET form; filters combine with OR logic) -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm px-5 py-4 mb-5">
    <form method="GET" action="{{ route('admin.laporan') }}" class="flex flex-col sm:flex-row sm:items-end gap-4">
        <div class="flex-1">
            <h2 class="font-semibold text-slate-800 text-sm mb-0.5">Penapis Laporan</h2>
            <p class="text-xs text-slate-400">Pilih penapis untuk menyaring data.</p>
        </div>

        <div class="flex flex-wrap gap-3 items-end">
            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Tempoh</label>
                <select name="tempoh" onchange="this.form.submit()"
                        class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 w-40 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                    <option value="all" @selected($filters['tempoh'] === 'all')>Semua masa</option>
                    <option value="year" @selected($filters['tempoh'] === 'year')>Tahun ini</option>
                    <option value="q" @selected($filters['tempoh'] === 'q')>3 bulan lepas</option>
                    <option value="month" @selected($filters['tempoh'] === 'month')>Bulan ini</option>
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Sektor</label>
                <select name="sektor" onchange="this.form.submit()"
                        class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 w-40 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                    <option value="all" @selected($filters['sektor'] === 'all')>Semua sektor</option>
                    <option value="kerajaan" @selected($filters['sektor'] === 'kerajaan')>Kerajaan</option>
                    <option value="glc" @selected($filters['sektor'] === 'glc')>GLC</option>
                    <option value="berkanun" @selected($filters['sektor'] === 'berkanun')>Badan Berkanun</option>
                    <option value="swasta" @selected($filters['sektor'] === 'swasta')>Swasta</option>
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Status Pipeline</label>
                <select name="status" onchange="this.form.submit()"
                        class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 w-52 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                    <option value="all" @selected($filters['status'] === 'all')>Semua status</option>
                    <option value="new_lead" @selected($filters['status'] === 'new_lead')>New Lead</option>
                    <option value="dokumen_belum_lengkap" @selected($filters['status'] === 'dokumen_belum_lengkap')>Dokumen Belum Lengkap</option>
                    <option value="dokumen_lengkap" @selected($filters['status'] === 'dokumen_lengkap')>Dokumen Lengkap</option>
                    <option value="dalam_semakan" @selected($filters['status'] === 'dalam_semakan')>Dalam Semakan</option>
                    <option value="layak" @selected($filters['status'] === 'layak')>Layak</option>
                    <option value="tidak_layak" @selected($filters['status'] === 'tidak_layak')>Tidak Layak</option>
                    <option value="submit_bank" @selected($filters['status'] === 'submit_bank')>Submit Bank/Koperasi</option>
                    <option value="approved" @selected($filters['status'] === 'approved')>Approved</option>
                    <option value="rejected" @selected($filters['status'] === 'rejected')>Rejected</option>
                    <option value="disbursed" @selected($filters['status'] === 'disbursed')>Disbursed</option>
                    <option value="closed" @selected($filters['status'] === 'closed')>Closed</option>
                    <option value="follow_up" @selected($filters['status'] === 'follow_up')>Follow Up Semula</option>
                </select>
            </div>

            <a href="{{ route('admin.laporan') }}" class="text-sm font-medium text-slate-500 px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Reset</a>

            <div class="flex flex-col justify-end">
                <span id="report-range" class="text-xs text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg font-medium whitespace-nowrap">{{ $report['label'] }}</span>
            </div>
        </div>
    </form>
</div>

<!-- Summary cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Jumlah Permohonan</p>
        <p id="sum-total" class="text-3xl font-bold text-slate-800">0</p>
        <p class="text-xs text-slate-400 mt-1">Bagi tempoh dipilih</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Kadar Kelulusan</p>
        <p id="sum-rate" class="text-3xl font-bold text-emerald-600">0%</p>
        <p class="text-xs text-slate-400 mt-1">Daripada jumlah diproses</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Sektor Kerajaan</p>
        <p id="sum-kerajaan" class="text-3xl font-bold text-navy">0</p>
        <p class="text-xs text-slate-400 mt-1">Permohonan</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Sektor Swasta</p>
        <p id="sum-swasta" class="text-3xl font-bold text-gold">0</p>
        <p class="text-xs text-slate-400 mt-1">Permohonan</p>
    </div>
</div>

<!-- Breakdown by sector + status -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-semibold text-slate-800 text-sm">Pecahan Mengikut Sektor</h3>
            <span id="sector-note" class="text-[10px] font-medium text-navy bg-navy/5 px-2 py-1 rounded-md hidden"></span>
        </div>
        <div id="sector-bars" class="space-y-4"></div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 text-sm mb-5">Pecahan Mengikut Status</h3>
        <div id="status-bars" class="space-y-4"></div>
    </div>

</div>

<!-- Monthly trend -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
    <h3 class="font-semibold text-slate-800 text-sm mb-1">Trend Bulanan</h3>
    <p class="text-xs text-slate-400 mb-6">Jumlah permohonan diterima setiap bulan</p>
    <div id="monthly-bars" class="h-36 flex items-end gap-2"></div>
</div>

<script>
// Single server-computed dataset for the current filter combination (OR logic).
const REPORT = @json($report);

const SECTORS = [
    { key: 'kerajaan', name: 'Kerajaan',       color: 'bg-navy' },
    { key: 'glc',      name: 'GLC',            color: 'bg-gold' },
    { key: 'berkanun', name: 'Badan Berkanun', color: 'bg-emerald-500' },
    { key: 'swasta',   name: 'Swasta',         color: 'bg-slate-400' },
];
const PIPELINE_STATUSES = [
    { key: 'new_lead',              name: 'New Lead',             color: 'bg-blue-400' },
    { key: 'dokumen_belum_lengkap', name: 'Dokumen Belum Lengkap',color: 'bg-amber-400' },
    { key: 'dokumen_lengkap',       name: 'Dokumen Lengkap',      color: 'bg-teal-500' },
    { key: 'dalam_semakan',         name: 'Dalam Semakan',        color: 'bg-sky-500' },
    { key: 'layak',                 name: 'Layak',                color: 'bg-emerald-400' },
    { key: 'tidak_layak',           name: 'Tidak Layak',          color: 'bg-red-400' },
    { key: 'submit_bank',           name: 'Submit Bank/Koperasi', color: 'bg-purple-500' },
    { key: 'approved',              name: 'Approved',             color: 'bg-emerald-600' },
    { key: 'rejected',              name: 'Rejected',             color: 'bg-red-600' },
    { key: 'disbursed',             name: 'Disbursed',            color: 'bg-green-600' },
    { key: 'closed',                name: 'Closed',               color: 'bg-slate-500' },
    { key: 'follow_up',             name: 'Follow Up Semula',     color: 'bg-orange-400' },
];
const MONTHS = ['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ogo','Sep','Okt','Nov','Dis'];

const pct = (n, total) => total ? Math.round(n / total * 100) : 0;
const fmt = (n) => n.toLocaleString('en-US');

function barRow(name, count, percent, color, dimmed) {
    return `<div class="${dimmed ? 'opacity-25' : ''} transition-opacity duration-300">
        <div class="flex justify-between text-xs text-slate-600 mb-1.5">
            <span class="font-medium">${name}</span>
            <span class="text-slate-400">${fmt(count)} (${percent}%)</span>
        </div>
        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
            <div class="${color} h-full rounded-full transition-all duration-500" style="width:${percent}%"></div>
        </div>
    </div>`;
}

function renderReport() {
    const d = REPORT;

    // Summary cards
    document.getElementById('sum-total').textContent    = fmt(d.total);
    document.getElementById('sum-rate').textContent     = d.rate + '%';
    document.getElementById('sum-kerajaan').textContent = fmt(d.sectors.kerajaan);
    document.getElementById('sum-swasta').textContent   = fmt(d.sectors.swasta);

    // Sector breakdown (real filtered counts)
    document.getElementById('sector-bars').innerHTML = SECTORS
        .map(s => barRow(s.name, d.sectors[s.key], pct(d.sectors[s.key], d.total), s.color, false))
        .join('');

    // Pipeline status breakdown (real filtered counts)
    document.getElementById('status-bars').innerHTML = PIPELINE_STATUSES
        .map(s => barRow(s.name, d.pipeline[s.key], pct(d.pipeline[s.key], d.total), s.color, false))
        .join('');

    // Monthly trend
    const max = Math.max(...d.monthly, 1);
    document.getElementById('monthly-bars').innerHTML = d.monthly.map((v, i) => {
        const h = v === 0 ? 4 : Math.round(v / max * 118) + 8;
        const barColor = v === 0 ? 'bg-slate-100' : 'bg-navy/80 hover:bg-navy';
        return `<div class="flex-1 flex flex-col items-center gap-1">
            <span class="text-[9px] font-semibold text-slate-400">${v || ''}</span>
            <div class="w-full rounded-t ${barColor} transition-all duration-500" style="height:${h}px" title="${MONTHS[i]}: ${v}"></div>
            <span class="text-[9px] text-slate-400">${MONTHS[i]}</span>
        </div>`;
    }).join('');
}

document.addEventListener('DOMContentLoaded', renderReport);
</script>

@endsection
