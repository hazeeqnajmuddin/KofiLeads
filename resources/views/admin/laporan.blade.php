@extends('layouts.admin')

@section('title', 'Laporan')
@section('page_title', 'Laporan')
@section('page_subtitle', 'Analisis dan pecahan data permohonan')

@section('admin_content')

<!-- Filter toolbar -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm px-5 py-4 mb-5">
    <form method="GET" action="{{ route('admin.laporan') }}" id="filter-form" class="flex flex-col gap-3">
        <input type="hidden" name="tahun" id="tahun-input" value="{{ $filters['tahun'] }}">

        <!-- Controls row -->
        <div class="flex flex-col sm:flex-row sm:items-end gap-4">
            <div class="flex-1">
                <h2 class="font-semibold text-slate-800 text-sm mb-0.5">Penapis Laporan</h2>
                <p class="text-xs text-slate-400">Sektor dan status gabung dengan logik ATAU. Tarikh tapis mengikut tarikh status terakhir.</p>
            </div>

            <div class="flex flex-wrap gap-3 items-end">
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
                        <option value="follow_up" @selected($filters['status'] === 'follow_up')>Follow Up Semula</option>
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Tarikh Status</label>
                    <select id="date-mode-select" name="date_mode"
                            class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 w-44 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                        <option value="all"    @selected($filters['date_mode'] === 'all')>Semua masa</option>
                        <option value="today"  @selected($filters['date_mode'] === 'today')>Hari ini</option>
                        <option value="minggu" @selected($filters['date_mode'] === 'minggu')>Minggu ini</option>
                        <option value="bulan"  @selected($filters['date_mode'] === 'bulan')>Bulan ini</option>
                        <option value="custom" @selected($filters['date_mode'] === 'custom')>Tarikh tertentu</option>
                    </select>
                </div>

                <a href="{{ route('admin.laporan') }}" class="text-sm font-medium text-slate-500 px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Reset</a>

                <div class="flex flex-col justify-end">
                    <span class="text-xs text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg font-medium whitespace-nowrap">{{ $report['label'] }}</span>
                </div>
            </div>
        </div>

        <!-- Custom date range row (shown only when Tarikh tertentu selected) -->
        <div id="custom-date-range" class="{{ $filters['date_mode'] !== 'custom' ? 'hidden' : '' }} flex flex-wrap gap-3 items-end border-t border-slate-100 pt-3">
            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Dari</label>
                <input type="date" name="date_from" value="{{ $filters['date_from'] }}"
                       class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Hingga</label>
                <input type="date" name="date_to" value="{{ $filters['date_to'] }}"
                       class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
            </div>
            <button type="submit"
                    class="text-sm font-semibold text-white bg-navy px-4 py-1.5 rounded-lg hover:bg-navy/90 transition">Guna</button>
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

<!-- Performance panels: leads per live host / per platform (for the selected period) -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

    <!-- Prestasi Kod Rujukan -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-slate-800 text-sm">Prestasi Kod Rujukan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Bilangan lead setiap live host · {{ $report['label'] }}</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-2.5 text-left">Live Host</th>
                        <th class="px-4 py-2.5 text-left">Kod</th>
                        <th class="px-4 py-2.5 text-center">Lead</th>
                        <th class="px-6 py-2.5 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($refPerformance as $r)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-6 py-3 text-slate-700 font-medium">
                            {{ $r['host_name'] }}
                            @if($r['is_active'])<span class="text-[9px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-1.5 py-0.5 rounded-full ml-1">AKTIF</span>@endif
                        </td>
                        <td class="px-4 py-3"><span class="font-mono text-xs text-slate-500">{{ $r['code'] }}</span></td>
                        <td class="px-4 py-3 text-center font-bold text-navy">{{ $r['count'] }}</td>
                        <td class="px-6 py-3 text-right">
                            @if($r['count'] > 0)
                            <a href="{{ route('admin.permohonan', array_filter(['kod_rujukan' => $r['code'], 'date_mode' => $filters['date_mode'], 'date_from' => $filters['date_from'], 'date_to' => $filters['date_to']])) }}"
                               class="text-xs font-medium text-navy hover:text-gold transition whitespace-nowrap">Lihat pemohon →</a>
                            @else
                            <span class="text-xs text-slate-300">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-slate-400">Tiada kod rujukan lagi. Jana di Tetapan Laman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Prestasi Platform -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800 text-sm">Prestasi Platform</h3>
            <p class="text-xs text-slate-400 mt-0.5">Bilangan lead setiap platform · {{ $report['label'] }}</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-2.5 text-left">Platform</th>
                        <th class="px-6 py-2.5 text-center">Lead</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($platformPerformance as $p)
                    <tr class="hover:bg-slate-50/70 transition">
                        <td class="px-6 py-3 text-slate-700 font-medium">{{ $p['label'] }}</td>
                        <td class="px-6 py-3 text-center font-bold text-navy">{{ $p['count'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Monthly trend -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 mb-5">
    <div class="flex items-start justify-between mb-1">
        <div>
            <h3 class="font-semibold text-slate-800 text-sm">Trend Bulanan</h3>
            <p class="text-xs text-slate-400 mt-0.5">Jumlah permohonan diterima setiap bulan (berdasarkan tarikh hantar)</p>
        </div>
        <select id="tahun-select"
                class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
            @foreach($availableYears as $year)
                <option value="{{ $year }}" @selected($filters['tahun'] === $year)>{{ $year }}</option>
            @endforeach
        </select>
    </div>
    <div id="monthly-bars" class="h-36 flex items-end gap-2 mt-6"></div>
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

<script>
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
    { key: 'follow_up',             name: 'Follow Up Semula',     color: 'bg-orange-400' },
];
const MONTHS = ['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ogo','Sep','Okt','Nov','Dis'];

const pct = (n, total) => total ? Math.round(n / total * 100) : 0;
const fmt = (n) => n.toLocaleString('en-US');

function barRow(name, count, percent, color) {
    return `<div>
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

    document.getElementById('sum-total').textContent    = fmt(d.total);
    document.getElementById('sum-rate').textContent     = d.rate + '%';
    document.getElementById('sum-kerajaan').textContent = fmt(d.sectors.kerajaan);
    document.getElementById('sum-swasta').textContent   = fmt(d.sectors.swasta);

    document.getElementById('sector-bars').innerHTML = SECTORS
        .map(s => barRow(s.name, d.sectors[s.key], pct(d.sectors[s.key], d.total), s.color))
        .join('');

    document.getElementById('status-bars').innerHTML = PIPELINE_STATUSES
        .map(s => barRow(s.name, d.pipeline[s.key], pct(d.pipeline[s.key], d.total), s.color))
        .join('');

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

document.addEventListener('DOMContentLoaded', function () {
    renderReport();

    const dateModeSelect = document.getElementById('date-mode-select');
    const customRange    = document.getElementById('custom-date-range');

    dateModeSelect.addEventListener('change', function () {
        if (this.value === 'custom') {
            customRange.classList.remove('hidden');
        } else {
            customRange.classList.add('hidden');
            this.form.submit();
        }
    });

    document.getElementById('tahun-select').addEventListener('change', function () {
        document.getElementById('tahun-input').value = this.value;
        document.getElementById('filter-form').submit();
    });
});
</script>

@endsection
