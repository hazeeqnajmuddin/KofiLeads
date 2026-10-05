@extends('layouts.admin')

@section('title', 'Permohonan')

@section('admin_content')

@php
$pipelineConfig = [
    'new_lead'              => ['label' => 'New Lead',              'cls' => 'bg-blue-100 text-blue-800 border-blue-200'],
    'dokumen_belum_lengkap' => ['label' => 'Dokumen Belum Lengkap', 'cls' => 'bg-amber-100 text-amber-800 border-amber-300'],
    'dokumen_lengkap'       => ['label' => 'Dokumen Lengkap',       'cls' => 'bg-teal-100 text-teal-800 border-teal-300'],
    'dalam_semakan'         => ['label' => 'Dalam Semakan',         'cls' => 'bg-sky-100 text-sky-800 border-sky-300'],
    'layak'                 => ['label' => 'Layak',                 'cls' => 'bg-emerald-100 text-emerald-800 border-emerald-300'],
    'tidak_layak'           => ['label' => 'Tidak Layak',           'cls' => 'bg-red-100 text-red-800 border-red-300'],
    'submit_bank'           => ['label' => 'Submit Bank/Koperasi',  'cls' => 'bg-purple-100 text-purple-800 border-purple-300'],
    'follow_up'             => ['label' => 'Follow Up Semula',      'cls' => 'bg-orange-100 text-orange-800 border-orange-300'],
];

$sektorLabels = [
    'kerajaan' => 'Kerajaan',
    'glc'      => 'GLC',
    'berkanun' => 'Badan Berkanun',
    'swasta'   => 'Swasta',
];

$masalahLabels = [
    'komitmen_tinggi' => 'Komitmen Tinggi',
    'ccris'           => 'CCRIS',
    'ctos'            => 'CTOS',
    'akpk'            => 'AKPK',
    'saa'             => 'SAA',
    'legal_action'    => 'Legal Action',
    'lain_lain'       => 'Lain-lain',
];

$statusKerjaLabels = ['tetap' => 'Tetap', 'kontrak' => 'Kontrak'];
$jenisLabels = ['slip_gaji' => 'Slip Gaji', 'laporan_ctos' => 'Laporan CTOS', 'penyata_epf' => 'Penyata EPF'];
$platformLabels = \App\Models\LeadPlatform::options();
@endphp

<!-- Filters + table card -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

    <!-- Card header with filters (server-side GET form) -->
    <div class="px-6 py-5 border-b border-slate-100">
        <form method="GET" action="{{ route('admin.permohonan') }}" class="space-y-4">

            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="font-semibold text-slate-800 text-base mb-0.5">Senarai Permohonan</h2>
                    <p class="text-xs text-slate-400">Klik nama atau baris untuk lihat butiran penuh. Tukar status terus dalam lajur Pipeline.</p>
                </div>
                <span class="text-xs text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg font-medium whitespace-nowrap flex-shrink-0">{{ $leads->total() }} rekod</span>
            </div>

            {{-- Uniform filter grid: every control fills its cell so they align neatly --}}
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3 items-end">

                <div class="flex flex-col gap-1 col-span-2 md:col-span-1">
                    <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Cari Nama / No. Tel</label>
                    <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Nama atau telefon..."
                           class="w-full text-sm border border-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Status</label>
                    <select name="status" onchange="this.form.submit()"
                            class="w-full text-sm border border-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                        <option value="">Semua Status</option>
                        @foreach($pipelineConfig as $val => $cfg)
                        <option value="{{ $val }}" @selected($filters['status'] === $val)>{{ $cfg['label'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Sektor</label>
                    <select name="sektor" onchange="this.form.submit()"
                            class="w-full text-sm border border-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                        <option value="">Semua Sektor</option>
                        @foreach($sektorLabels as $val => $label)
                        <option value="{{ $val }}" @selected($filters['sektor'] === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Kod Rujukan</label>
                    <select name="kod_rujukan" onchange="this.form.submit()"
                            class="w-full text-sm border border-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                        <option value="">Semua Kod</option>
                        @foreach($referenceCodes as $rc)
                        <option value="{{ $rc->code }}" @selected($filters['kod_rujukan'] === $rc->code)>{{ $rc->code }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Pinjaman 3 Bulan</label>
                    <select name="pinjaman" onchange="this.form.submit()"
                            class="w-full text-sm border border-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                        <option value="">Semua</option>
                        <option value="1" @selected($filters['pinjaman'] === '1')>Ya</option>
                        <option value="0" @selected($filters['pinjaman'] === '0')>Tidak</option>
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Tarikh Hantar</label>
                    <select id="perm-date-mode" name="date_mode"
                            class="w-full text-sm border border-slate-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                        <option value=""       @selected($filters['date_mode'] === '')>Semua masa</option>
                        <option value="today"  @selected($filters['date_mode'] === 'today')>Hari ini</option>
                        <option value="minggu" @selected($filters['date_mode'] === 'minggu')>Minggu ini</option>
                        <option value="bulan"  @selected($filters['date_mode'] === 'bulan')>Bulan ini</option>
                        <option value="custom" @selected($filters['date_mode'] === 'custom')>Tarikh tertentu</option>
                    </select>
                </div>
            </div>

            {{-- Custom date range (shown only when "Tarikh tertentu") --}}
            <div id="perm-custom-date" class="{{ $filters['date_mode'] !== 'custom' ? 'hidden' : '' }} flex flex-wrap gap-3 items-end">
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
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="text-sm font-semibold bg-navy text-white px-5 py-1.5 rounded-lg hover:bg-navy-dark transition">Cari</button>
                <a href="{{ route('admin.permohonan') }}" class="text-sm font-medium text-slate-500 px-3 py-1.5 rounded-lg hover:bg-slate-100 transition">Reset</a>
            </div>
        </form>
        <script>
            // Auto-submit on date preset; show the custom range instead of submitting for "custom".
            document.getElementById('perm-date-mode').addEventListener('change', function () {
                if (this.value === 'custom') {
                    document.getElementById('perm-custom-date').classList.remove('hidden');
                } else {
                    this.form.submit();
                }
            });
        </script>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="stack-table w-full text-sm min-w-[960px]" id="permohonan-table">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">No. Tel</th>
                    <th class="px-5 py-3 text-left">Sektor</th>
                    <th class="px-5 py-3 text-left">Majikan / Jawatan</th>
                    <th class="px-5 py-3 text-center">Status</th>
                    <th class="px-5 py-3 text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody id="permohonan-body" class="divide-y divide-slate-100">

                @forelse($leads as $lead)
                @php
                    $pc = $pipelineConfig[$lead->pipeline_status] ?? ['label' => $lead->pipeline_status, 'cls' => 'bg-slate-100 text-slate-600 border-slate-300'];
                    $phone = preg_replace('/\D/', '', $lead->no_telefon);
                    $sektorLabel = $sektorLabels[$lead->sektor] ?? $lead->sektor;
                    $masalahText = $lead->masalah->map(function ($m) use ($masalahLabels) {
                        $label = $masalahLabels[$m->masalah] ?? $m->masalah;
                        return $m->masalah === 'lain_lain' && $m->keterangan ? "{$label}: {$m->keterangan}" : $label;
                    })->implode(', ');
                    $platformText = $lead->platforms->map(function ($p) use ($platformLabels) {
                        $label = $platformLabels[$p->platform] ?? ($p->platform === 'lain_lain' ? 'Lain-lain' : $p->platform);
                        return $p->platform === 'lain_lain' && $p->keterangan ? "{$label}: {$p->keterangan}" : $label;
                    })->implode(', ');
                    $pinjamanText = $lead->apply_pinjaman_3bulan
                        ? 'Ya' . ($lead->bank_koperasi_nama ? " — {$lead->bank_koperasi_nama}" : '')
                        : 'Tidak';
                    $dokumenJson = $lead->dokumen->map(fn ($d) => [
                        'id'    => $d->id,
                        'label' => ($jenisLabels[$d->jenis] ?? $d->jenis) . ($d->bulan ? " (Bulan {$d->bulan})" : ''),
                        'nama'  => $d->nama_fail,
                    ])->values();
                    $waText = 'Assalamualaikum ' . $lead->nama . ', kami dari pihak perundingan kewangan ingin maklumkan status permohonan anda.';
                @endphp
                <tr class="table-row cursor-pointer transition hover:bg-slate-50/80 select-none"
                    onclick="viewDetails(this)"
                    data-nama="{{ $lead->nama }}"
                    data-tel-display="{{ $lead->no_telefon }}"
                    data-emel="{{ $lead->emel }}"
                    data-daerah="{{ $lead->daerah }}"
                    data-poskod="{{ $lead->poskod }}"
                    data-pipeline-label="{{ $pc['label'] }}"
                    data-pipeline-cls="status-badge {{ $pc['cls'] }}"
                    data-sektor-label="{{ $sektorLabel }}"
                    data-nama-majikan="{{ $lead->nama_majikan }}"
                    data-jawatan="{{ $lead->jawatan }}"
                    data-gaji="{{ $lead->gaji_asas }}"
                    data-status-kerja="{{ $statusKerjaLabels[$lead->status_pekerjaan] ?? $lead->status_pekerjaan }}"
                    data-masalah="{{ $masalahText }}"
                    data-kod-rujukan="{{ $lead->kod_rujukan }}"
                    data-platform="{{ $platformText }}"
                    data-pinjaman="{{ $pinjamanText }}"
                    data-dokumen="{{ $dokumenJson->toJson() }}"
                    data-phone="{{ $phone }}">
                    <td class="px-5 py-4 font-semibold text-navy cell-title hover:underline underline-offset-2">{{ $lead->nama }}</td>
                    <td class="px-5 py-4 text-slate-500" data-label="No. Tel">{{ $lead->no_telefon }}</td>
                    <td class="px-5 py-4 text-slate-600" data-label="Sektor">{{ $sektorLabel }}</td>
                    <td class="px-5 py-4 text-slate-600" data-label="Majikan">{{ $lead->nama_majikan }} / {{ $lead->jawatan }}</td>
                    <td class="px-5 py-4 text-center" data-label="Status" onclick="event.stopPropagation()">
                        <form method="POST" action="{{ route('admin.leads.updateStatus', $lead) }}">
                            @csrf
                            @method('PATCH')
                            <select name="pipeline_status" onchange="this.form.submit()"
                                class="pipeline-select text-xs font-semibold border rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 cursor-pointer {{ $pc['cls'] }}">
                                @foreach($pipelineConfig as $val => $cfg)
                                <option value="{{ $val }}" @selected($lead->pipeline_status === $val)>{{ $cfg['label'] }}</option>
                                @endforeach
                            </select>
                        </form>
                    </td>
                    <td class="px-5 py-4 text-center" data-label="Tindakan" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-center gap-2">
                            <a href="https://wa.me/{{ $phone }}?text={{ urlencode($waText) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1.5 rounded-lg hover:bg-emerald-100 transition" title="WhatsApp">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                WA
                            </a>
                            {{-- Merged PDF of the lead's documents — opens inline in a new tab (Phase 9) --}}
                            @if($lead->dokumen->isNotEmpty())
                            <a href="{{ route('admin.leads.pdf', $lead) }}" target="_blank" rel="noopener"
                                class="inline-flex items-center gap-1.5 text-xs font-medium text-rose-700 bg-rose-50 border border-rose-200 px-2.5 py-1.5 rounded-lg hover:bg-rose-100 transition" title="Lihat / muat turun PDF gabungan">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-6 4h6"/>
                                </svg>
                                PDF
                            </a>
                            @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-300 bg-slate-50 border border-slate-200 px-2.5 py-1.5 rounded-lg cursor-not-allowed" title="Tiada dokumen">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-6 4h6"/>
                                </svg>
                                PDF
                            </span>
                            @endif
                            <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}"
                                  data-confirm="Padam rekod {{ $lead->nama }}? Tindakan ini tidak boleh dibatalkan."
                                  data-confirm-title="Padam Rekod"
                                  data-confirm-ok="Ya, padam"
                                  data-confirm-danger>
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1.5 text-xs font-medium text-red-600 bg-red-50 border border-red-200 px-2.5 py-1.5 rounded-lg hover:bg-red-100 transition" title="Padam rekod">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Padam
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <svg class="w-10 h-10 text-slate-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <p class="text-slate-400 text-sm">Tiada rekod dijumpai</p>
                        <p class="text-slate-300 text-xs mt-1">Cuba ubah penapis carian anda</p>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    @if($leads->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">
        {{ $leads->links() }}
    </div>
    @endif

</div>

<!-- View Details Modal -->
<div id="details-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeDetailsModal()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg flex flex-col max-h-[90vh]">

        <!-- Modal header -->
        <div class="px-6 pt-5 pb-4 border-b border-slate-100 flex items-start justify-between gap-4 flex-shrink-0">
            <div>
                <h3 id="modal-nama" class="font-bold text-slate-800 text-lg leading-snug"></h3>
                <div class="flex items-center gap-2 mt-1.5">
                    <span id="modal-pipeline" class="status-badge text-xs"></span>
                </div>
            </div>
            <button onclick="closeDetailsModal()" class="text-slate-400 hover:text-slate-600 transition mt-0.5 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Scrollable body -->
        <div class="overflow-y-auto flex-1 px-6 py-5 space-y-6">

            <!-- Section 1: Maklumat Peribadi -->
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <span class="w-4 h-4 bg-navy/10 text-navy rounded flex items-center justify-center text-[9px] font-bold flex-shrink-0">1</span>
                    Maklumat Peribadi
                </p>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">No. Telefon</span>
                        <span id="modal-tel" class="font-medium text-slate-700 text-right"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Emel</span>
                        <span id="modal-emel" class="font-medium text-slate-700 text-right"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Daerah</span>
                        <span id="modal-daerah" class="font-medium text-slate-700 text-right"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Poskod</span>
                        <span id="modal-poskod" class="font-medium text-slate-700 text-right"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Kod Rujukan</span>
                        <span id="modal-kod-rujukan" class="font-medium text-slate-700 text-right"></span>
                    </div>
                    <div class="flex justify-between items-start text-sm py-1.5">
                        <span class="text-slate-400 w-36 flex-shrink-0">Platform</span>
                        <span id="modal-platform" class="font-medium text-slate-700 text-right"></span>
                    </div>
                </div>
            </div>

            <!-- Section 2: Maklumat Pekerjaan -->
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <span class="w-4 h-4 bg-navy/10 text-navy rounded flex items-center justify-center text-[9px] font-bold flex-shrink-0">2</span>
                    Maklumat Pekerjaan
                </p>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Sektor</span>
                        <span id="modal-sektor" class="font-medium text-slate-700 text-right"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Nama Majikan</span>
                        <span id="modal-nama-majikan" class="font-medium text-slate-700 text-right"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Jawatan</span>
                        <span id="modal-jawatan" class="font-medium text-slate-700 text-right"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Gaji Asas</span>
                        <span id="modal-gaji" class="font-medium text-slate-700 text-right"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Status Pekerjaan</span>
                        <span id="modal-status-kerja" class="font-medium text-slate-700 text-right"></span>
                    </div>
                    <div class="flex justify-between items-start text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Masalah Utama</span>
                        <div id="modal-masalah" class="flex flex-wrap gap-1 justify-end max-w-[55%]"></div>
                    </div>
                    <div class="flex justify-between items-start text-sm py-1.5">
                        <span class="text-slate-400 w-36 flex-shrink-0">Pinjaman 3 Bulan Lepas</span>
                        <span id="modal-pinjaman" class="font-medium text-slate-700 text-right max-w-[55%]"></span>
                    </div>
                </div>
            </div>

            <!-- Section 3: Dokumen Sokongan -->
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <span class="w-4 h-4 bg-navy/10 text-navy rounded flex items-center justify-center text-[9px] font-bold flex-shrink-0">3</span>
                    Dokumen Sokongan
                </p>
                <div id="modal-dokumen" class="space-y-2"></div>
            </div>

        </div>

        <!-- Modal footer -->
        <div class="px-6 pb-5 pt-4 border-t border-slate-100 flex gap-3 flex-shrink-0">
            <button onclick="closeDetailsModal()" class="flex-1 py-2.5 px-4 rounded-xl border border-slate-200 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">Tutup</button>
            <a id="modal-wa" href="#" target="_blank"
               class="flex-1 py-2.5 px-4 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-semibold text-center transition">
                WhatsApp
            </a>
        </div>

    </div>
</div>

<script>
const SELECT_BASE = 'pipeline-select text-xs font-semibold border rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 cursor-pointer';
const PIPELINE_SELECT_CLS = {
    new_lead:               'bg-blue-100 text-blue-800 border-blue-200',
    dokumen_belum_lengkap:  'bg-amber-100 text-amber-800 border-amber-300',
    dokumen_lengkap:        'bg-teal-100 text-teal-800 border-teal-300',
    dalam_semakan:          'bg-sky-100 text-sky-800 border-sky-300',
    layak:                  'bg-emerald-100 text-emerald-800 border-emerald-300',
    tidak_layak:            'bg-red-100 text-red-800 border-red-300',
    submit_bank:            'bg-purple-100 text-purple-800 border-purple-300',
    follow_up:              'bg-orange-100 text-orange-800 border-orange-300',
};

// URL template for private document download (id swapped in at click time)
const DOKUMEN_URL = "{{ route('admin.dokumen.download', ['dokumen' => '__ID__']) }}";

function applySelectStyle(sel) {
    sel.className = SELECT_BASE + ' ' + (PIPELINE_SELECT_CLS[sel.value] || 'bg-slate-100 text-slate-600 border-slate-300');
}

function set(id, text) { document.getElementById(id).textContent = text; }

function viewDetails(row) {
    const d = row.dataset;
    const waText = encodeURIComponent('Assalamualaikum ' + d.nama + ', kami dari pihak perundingan kewangan ingin maklumkan status permohonan anda.');

    // Header
    set('modal-nama', d.nama);
    const pipelineEl = document.getElementById('modal-pipeline');
    pipelineEl.className = d.pipelineCls;
    pipelineEl.innerHTML = '<span class="dot"></span>' + d.pipelineLabel;

    // Section 1
    set('modal-tel',    d.telDisplay || '—');
    set('modal-emel',   d.emel   || '—');
    set('modal-daerah', d.daerah || '—');
    set('modal-poskod', d.poskod || '—');
    set('modal-kod-rujukan', d.kodRujukan || '—');
    set('modal-platform',    d.platform   || '—');

    // Section 2
    set('modal-sektor',       d.sektorLabel || '—');
    set('modal-nama-majikan', d.namaMajikan || '—');
    set('modal-jawatan',      d.jawatan     || '—');
    set('modal-gaji',         d.gaji ? 'RM ' + Number(d.gaji).toLocaleString() : '—');
    set('modal-status-kerja', d.statusKerja || '—');
    set('modal-pinjaman',     d.pinjaman    || '—');

    const masalahEl = document.getElementById('modal-masalah');
    masalahEl.innerHTML = '';
    if (d.masalah) {
        d.masalah.split(', ').forEach(m => {
            const span = document.createElement('span');
            span.className = 'inline-block bg-rose-50 text-rose-700 border border-rose-200 rounded-md px-2 py-0.5 text-[11px] font-medium';
            span.textContent = m.trim();
            masalahEl.appendChild(span);
        });
    }

    // Section 3: real documents with download links
    const docEl = document.getElementById('modal-dokumen');
    docEl.innerHTML = '';
    let docs = [];
    try { docs = JSON.parse(d.dokumen || '[]'); } catch (e) { docs = []; }
    if (docs.length === 0) {
        docEl.innerHTML = '<p class="text-sm text-slate-400 py-1.5">Tiada dokumen dimuat naik.</p>';
    } else {
        docs.forEach(doc => {
            const a = document.createElement('a');
            a.href = DOKUMEN_URL.replace('__ID__', doc.id);
            a.className = 'flex items-center justify-between gap-3 text-sm py-2 px-3 rounded-lg border border-slate-100 hover:border-navy/30 hover:bg-slate-50 transition';
            a.innerHTML =
                '<span class="text-slate-600">' + doc.label + '</span>' +
                '<span class="inline-flex items-center gap-1.5 text-navy font-medium text-xs flex-shrink-0">' +
                '<svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>' +
                'Muat turun</span>';
            docEl.appendChild(a);
        });
    }

    // Footer WA
    document.getElementById('modal-wa').href = 'https://wa.me/' + d.phone + '?text=' + waText;

    document.getElementById('details-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDetailsModal() {
    document.getElementById('details-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.pipeline-select').forEach(applySelectStyle);
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeDetailsModal();
});
</script>

@endsection
