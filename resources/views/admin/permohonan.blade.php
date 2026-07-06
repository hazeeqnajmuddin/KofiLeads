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
    'approved'              => ['label' => 'Approved',              'cls' => 'bg-emerald-200 text-emerald-900 border-emerald-400'],
    'rejected'              => ['label' => 'Rejected',              'cls' => 'bg-red-200 text-red-900 border-red-400'],
    'disbursed'             => ['label' => 'Disbursed',             'cls' => 'bg-green-200 text-green-900 border-green-400'],
    'closed'                => ['label' => 'Closed',                'cls' => 'bg-slate-200 text-slate-700 border-slate-400'],
    'follow_up'             => ['label' => 'Follow Up Semula',      'cls' => 'bg-orange-100 text-orange-800 border-orange-300'],
];

$rows = [
    [
        'nama'           => 'Ahmad Albab',
        'tel'            => '+60 12-345 6789',
        'phone'          => '60123456789',
        'emel'           => 'ahmad.albab@email.com',
        'daerah'         => 'Petaling Jaya',
        'poskod'         => '47810',
        'sektor'         => 'swasta',
        'sektorLabel'    => 'Swasta',
        'nama_majikan'   => 'Syarikat ABC Sdn Bhd',
        'jawatan'        => 'Pengurus',
        'majikan'        => 'Syarikat ABC Sdn Bhd / Pengurus',
        'gaji_asas'      => '4500',
        'status_kerja'   => 'Tetap',
        'masalah'        => ['Komitmen Tinggi', 'CCRIS'],
        'slip_gaji'      => true,
        'ctos_report'    => true,
        'penyata_epf'    => true,
        'pipeline'       => 'new_lead',
    ],
    [
        'nama'           => 'Siti Nurdiana',
        'tel'            => '+60 17-987 6543',
        'phone'          => '60179876543',
        'emel'           => 'siti.nurdiana@edu.gov.my',
        'daerah'         => 'Kuala Lumpur',
        'poskod'         => '50480',
        'sektor'         => 'awam',
        'sektorLabel'    => 'Awam',
        'nama_majikan'   => 'Kementerian Pendidikan Malaysia',
        'jawatan'        => 'Pensyarah',
        'majikan'        => 'Kementerian Pendidikan / Pensyarah',
        'gaji_asas'      => '5200',
        'status_kerja'   => 'Tetap',
        'masalah'        => ['CTOS'],
        'slip_gaji'      => true,
        'ctos_report'    => true,
        'penyata_epf'    => false,
        'pipeline'       => 'approved',
    ],
    [
        'nama'           => 'Mohd Faizal bin Hamid',
        'tel'            => '+60 11-2233 4455',
        'phone'          => '601122334455',
        'emel'           => '',
        'daerah'         => 'Shah Alam',
        'poskod'         => '40150',
        'sektor'         => 'swasta',
        'sektorLabel'    => 'Swasta',
        'nama_majikan'   => 'Logistik Jaya Sdn Bhd',
        'jawatan'        => 'Pemandu',
        'majikan'        => 'Logistik Jaya Sdn Bhd / Pemandu',
        'gaji_asas'      => '2800',
        'status_kerja'   => 'Kontrak',
        'masalah'        => ['Komitmen Tinggi', 'AKPK', 'Legal Action'],
        'slip_gaji'      => true,
        'ctos_report'    => false,
        'penyata_epf'    => true,
        'pipeline'       => 'rejected',
    ],
    [
        'nama'           => 'Nurul Ain Zainudin',
        'tel'            => '+60 13-567 8901',
        'phone'          => '601135678901',
        'emel'           => 'nurulain@hkl.gov.my',
        'daerah'         => 'Cheras',
        'poskod'         => '56100',
        'sektor'         => 'awam',
        'sektorLabel'    => 'Awam',
        'nama_majikan'   => 'Hospital Kuala Lumpur',
        'jawatan'        => 'Jururawat',
        'majikan'        => 'Hospital Kuala Lumpur / Jururawat',
        'gaji_asas'      => '3100',
        'status_kerja'   => 'Tetap',
        'masalah'        => ['CCRIS', 'CTOS'],
        'slip_gaji'      => false,
        'ctos_report'    => false,
        'penyata_epf'    => false,
        'pipeline'       => 'dokumen_belum_lengkap',
    ],
    [
        'nama'           => 'Khairul Anwar Othman',
        'tel'            => '+60 19-334 5566',
        'phone'          => '601933455566',
        'emel'           => '',
        'daerah'         => 'Subang Jaya',
        'poskod'         => '47500',
        'sektor'         => 'awam',
        'sektorLabel'    => 'Awam',
        'nama_majikan'   => 'Polis DiRaja Malaysia',
        'jawatan'        => 'Inspektor',
        'majikan'        => 'Polis DiRaja Malaysia / Inspektor',
        'gaji_asas'      => '4200',
        'status_kerja'   => 'Tetap',
        'masalah'        => ['Komitmen Tinggi'],
        'slip_gaji'      => true,
        'ctos_report'    => true,
        'penyata_epf'    => false,
        'pipeline'       => 'dalam_semakan',
    ],
    [
        'nama'           => 'Roslinda Md Yusof',
        'tel'            => '+60 16-778 9900',
        'phone'          => '601677899900',
        'emel'           => 'roslinda.perniagaan@gmail.com',
        'daerah'         => 'Klang',
        'poskod'         => '41000',
        'sektor'         => 'sendiri',
        'sektorLabel'    => 'Sendiri',
        'nama_majikan'   => 'Perniagaan Sendiri',
        'jawatan'        => 'Peniaga',
        'majikan'        => 'Perniagaan Sendiri / Peniaga',
        'gaji_asas'      => '3800',
        'status_kerja'   => 'Sendiri',
        'masalah'        => ['CCRIS', 'SAA'],
        'slip_gaji'      => true,
        'ctos_report'    => true,
        'penyata_epf'    => false,
        'pipeline'       => 'tidak_layak',
    ],
    [
        'nama'           => 'Zulkifli Hassan',
        'tel'            => '+60 12-100 2233',
        'phone'          => '601221002233',
        'emel'           => 'zulkifli.hassan@gmail.com',
        'daerah'         => 'Kajang',
        'poskod'         => '43000',
        'sektor'         => 'bersara',
        'sektorLabel'    => 'Pesara',
        'nama_majikan'   => 'Pesara Kerajaan',
        'jawatan'        => 'Bekas Pegawai Tadbir',
        'majikan'        => 'Pesara Kerajaan / Bekas Pegawai',
        'gaji_asas'      => '2600',
        'status_kerja'   => 'Pesara',
        'masalah'        => ['Komitmen Tinggi', 'CTOS'],
        'slip_gaji'      => true,
        'ctos_report'    => false,
        'penyata_epf'    => false,
        'pipeline'       => 'dokumen_lengkap',
    ],
];
@endphp

<!-- Filters + table card -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

    <!-- Card header with filters -->
    <div class="px-6 py-5 border-b border-slate-100">
        <div class="flex flex-col sm:flex-row sm:items-end gap-4">

            <div class="flex-1">
                <h2 class="font-semibold text-slate-800 text-base mb-0.5">Senarai Permohonan</h2>
                <p class="text-xs text-slate-400">Klik nama atau baris untuk lihat butiran penuh. Tukar status terus dalam lajur Pipeline.</p>
            </div>

            <div class="flex flex-wrap gap-3">

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Cari Nama</label>
                    <input type="text" id="filter-nama" oninput="filterTable()"
                           placeholder="Nama pemohon..."
                           class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 w-40 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Cari No. Tel</label>
                    <input type="text" id="filter-tel" oninput="filterTable()"
                           placeholder="Nombor telefon..."
                           class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 w-40 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Status Pipeline</label>
                    <select id="filter-status" onchange="filterTable()"
                            class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 w-52 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                        <option value="">Semua Status</option>
                        <option value="new_lead">New Lead</option>
                        <option value="dokumen_belum_lengkap">Dokumen Belum Lengkap</option>
                        <option value="dokumen_lengkap">Dokumen Lengkap</option>
                        <option value="dalam_semakan">Dalam Semakan</option>
                        <option value="layak">Layak</option>
                        <option value="tidak_layak">Tidak Layak</option>
                        <option value="submit_bank">Submit Bank/Koperasi</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="disbursed">Disbursed</option>
                        <option value="closed">Closed</option>
                        <option value="follow_up">Follow Up Semula</option>
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Sektor</label>
                    <select id="filter-sektor" onchange="filterTable()"
                            class="text-sm border border-slate-200 rounded-lg px-3 py-1.5 w-40 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy transition bg-slate-50">
                        <option value="">Semua Sektor</option>
                        <option value="awam">Sektor Awam</option>
                        <option value="swasta">Sektor Swasta</option>
                        <option value="sendiri">Bekerja Sendiri</option>
                        <option value="bersara">Pesara</option>
                    </select>
                </div>

                <div class="flex flex-col justify-end">
                    <span id="row-count" class="text-xs text-slate-400 bg-slate-100 px-3 py-1.5 rounded-lg font-medium">0 rekod</span>
                </div>

            </div>
        </div>
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
                    <th class="px-5 py-3 text-center">Status Pipeline</th>
                    <th class="px-5 py-3 text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody id="permohonan-body" class="divide-y divide-slate-100">

                @foreach($rows as $r)
                @php $pc = $pipelineConfig[$r['pipeline']] ?? ['label' => $r['pipeline'], 'cls' => 'bg-slate-100 text-slate-600 border-slate-300']; @endphp
                <tr class="table-row cursor-pointer transition hover:bg-slate-50/80 select-none"
                    onclick="viewDetails(this)"
                    data-nama="{{ $r['nama'] }}"
                    data-tel="{{ preg_replace('/\D/', '', $r['tel']) }}"
                    data-tel-display="{{ $r['tel'] }}"
                    data-emel="{{ $r['emel'] }}"
                    data-daerah="{{ $r['daerah'] }}"
                    data-poskod="{{ $r['poskod'] }}"
                    data-pipeline="{{ $r['pipeline'] }}"
                    data-sektor="{{ $r['sektor'] }}"
                    data-sektor-label="{{ $r['sektorLabel'] }}"
                    data-nama-majikan="{{ $r['nama_majikan'] }}"
                    data-jawatan="{{ $r['jawatan'] }}"
                    data-majikan="{{ $r['majikan'] }}"
                    data-gaji="{{ $r['gaji_asas'] }}"
                    data-status-kerja="{{ $r['status_kerja'] }}"
                    data-masalah="{{ implode(', ', $r['masalah']) }}"
                    data-slip-gaji="{{ $r['slip_gaji'] ? '1' : '0' }}"
                    data-ctos="{{ $r['ctos_report'] ? '1' : '0' }}"
                    data-epf="{{ $r['penyata_epf'] ? '1' : '0' }}"
                    data-phone="{{ $r['phone'] }}">
                    <td class="px-5 py-4 font-semibold text-navy cell-title hover:underline underline-offset-2">{{ $r['nama'] }}</td>
                    <td class="px-5 py-4 text-slate-500" data-label="No. Tel">{{ $r['tel'] }}</td>
                    <td class="px-5 py-4 text-slate-600" data-label="Sektor">{{ $r['sektorLabel'] }}</td>
                    <td class="px-5 py-4 text-slate-600" data-label="Majikan">{{ $r['majikan'] }}</td>
                    <td class="px-5 py-4 text-center" data-label="Status Pipeline" onclick="event.stopPropagation()">
                        <select onchange="updatePipeline(this)"
                            class="pipeline-select text-xs font-semibold border rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 cursor-pointer {{ $pc['cls'] }}">
                            @foreach($pipelineConfig as $val => $cfg)
                            <option value="{{ $val }}" {{ $r['pipeline'] === $val ? 'selected' : '' }}>{{ $cfg['label'] }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-5 py-4 text-center" data-label="Tindakan" onclick="event.stopPropagation()">
                        <div class="flex items-center justify-center gap-2">
                            <a href="https://wa.me/{{ $r['phone'] }}?text={{ urlencode('Assalamualaikum ' . $r['nama'] . ', kami dari Rahmah Consultancy Services ingin maklumkan status permohonan anda.') }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1.5 rounded-lg hover:bg-emerald-100 transition" title="WhatsApp">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                                WA
                            </a>
                            <button onclick="printLead(this.closest('tr').dataset)"
                                class="inline-flex items-center gap-1.5 text-xs font-medium text-navy bg-navy/5 border border-navy/20 px-2.5 py-1.5 rounded-lg hover:bg-navy/10 transition" title="Muat turun PDF">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                PDF
                            </button>
                            <button onclick="deleteLead(this)"
                                class="inline-flex items-center gap-1.5 text-xs font-medium text-red-600 bg-red-50 border border-red-200 px-2.5 py-1.5 rounded-lg hover:bg-red-100 transition" title="Padam rekod">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Padam
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    <!-- Empty state -->
    <div id="empty-state" class="hidden px-6 py-16 text-center">
        <svg class="w-10 h-10 text-slate-200 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <p class="text-slate-400 text-sm">Tiada rekod dijumpai</p>
        <p class="text-slate-300 text-xs mt-1">Cuba ubah penapis carian anda</p>
    </div>

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
                    <div class="flex justify-between items-center text-sm py-1.5">
                        <span class="text-slate-400 w-36 flex-shrink-0">Poskod</span>
                        <span id="modal-poskod" class="font-medium text-slate-700 text-right"></span>
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
                    <div class="flex justify-between items-start text-sm py-1.5">
                        <span class="text-slate-400 w-36 flex-shrink-0">Masalah Utama</span>
                        <div id="modal-masalah" class="flex flex-wrap gap-1 justify-end max-w-[55%]"></div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Dokumen Sokongan -->
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                    <span class="w-4 h-4 bg-navy/10 text-navy rounded flex items-center justify-center text-[9px] font-bold flex-shrink-0">3</span>
                    Dokumen Sokongan
                </p>
                <div class="space-y-2.5">
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Slip Gaji 3 Bulan</span>
                        <span id="modal-slip-gaji" class="status-badge text-xs"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm py-1.5 border-b border-slate-50">
                        <span class="text-slate-400 w-36 flex-shrink-0">Laporan CTOS</span>
                        <span id="modal-ctos" class="status-badge text-xs"></span>
                    </div>
                    <div class="flex justify-between items-center text-sm py-1.5">
                        <span class="text-slate-400 w-36 flex-shrink-0">Penyata EPF</span>
                        <span id="modal-epf" class="status-badge text-xs"></span>
                    </div>
                </div>
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
const PIPELINE_MAP = {
    new_lead:               { label: 'New Lead',              cls: 'status-badge bg-blue-100 text-blue-800 border-blue-200' },
    dokumen_belum_lengkap:  { label: 'Dokumen Belum Lengkap', cls: 'status-badge bg-amber-100 text-amber-800 border-amber-300' },
    dokumen_lengkap:        { label: 'Dokumen Lengkap',       cls: 'status-badge bg-teal-100 text-teal-800 border-teal-300' },
    dalam_semakan:          { label: 'Dalam Semakan',         cls: 'status-badge bg-sky-100 text-sky-800 border-sky-300' },
    layak:                  { label: 'Layak',                 cls: 'status-badge bg-emerald-100 text-emerald-800 border-emerald-300' },
    tidak_layak:            { label: 'Tidak Layak',           cls: 'status-badge bg-red-100 text-red-800 border-red-300' },
    submit_bank:            { label: 'Submit Bank/Koperasi',  cls: 'status-badge bg-purple-100 text-purple-800 border-purple-300' },
    approved:               { label: 'Approved',              cls: 'status-badge bg-emerald-200 text-emerald-900 border-emerald-400' },
    rejected:               { label: 'Rejected',              cls: 'status-badge bg-red-200 text-red-900 border-red-400' },
    disbursed:              { label: 'Disbursed',             cls: 'status-badge bg-green-200 text-green-900 border-green-400' },
    closed:                 { label: 'Closed',                cls: 'status-badge bg-slate-200 text-slate-700 border-slate-400' },
    follow_up:              { label: 'Follow Up Semula',      cls: 'status-badge bg-orange-100 text-orange-800 border-orange-300' },
};

const PIPELINE_SELECT_CLS = {
    new_lead:               'bg-blue-100 text-blue-800 border-blue-200',
    dokumen_belum_lengkap:  'bg-amber-100 text-amber-800 border-amber-300',
    dokumen_lengkap:        'bg-teal-100 text-teal-800 border-teal-300',
    dalam_semakan:          'bg-sky-100 text-sky-800 border-sky-300',
    layak:                  'bg-emerald-100 text-emerald-800 border-emerald-300',
    tidak_layak:            'bg-red-100 text-red-800 border-red-300',
    submit_bank:            'bg-purple-100 text-purple-800 border-purple-300',
    approved:               'bg-emerald-200 text-emerald-900 border-emerald-400',
    rejected:               'bg-red-200 text-red-900 border-red-400',
    disbursed:              'bg-green-200 text-green-900 border-green-400',
    closed:                 'bg-slate-200 text-slate-700 border-slate-400',
    follow_up:              'bg-orange-100 text-orange-800 border-orange-300',
};

const SELECT_BASE = 'pipeline-select text-xs font-semibold border rounded-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-navy/20 cursor-pointer';

function applySelectStyle(sel) {
    sel.className = SELECT_BASE + ' ' + (PIPELINE_SELECT_CLS[sel.value] || 'bg-slate-100 text-slate-600 border-slate-300');
}

function updatePipeline(sel) {
    sel.closest('tr').dataset.pipeline = sel.value;
    applySelectStyle(sel);
    filterTable();
}

function filterTable() {
    const nama   = document.getElementById('filter-nama').value.toLowerCase();
    const tel    = document.getElementById('filter-tel').value.replace(/\D/g, '');
    const status = document.getElementById('filter-status').value;
    const sektor = document.getElementById('filter-sektor').value.toLowerCase();
    const rows   = document.querySelectorAll('#permohonan-body .table-row');
    let visible  = 0;

    rows.forEach(row => {
        const match = (row.dataset.nama || '').toLowerCase().includes(nama)
                   && (tel    === '' || (row.dataset.tel || '').includes(tel))
                   && (status === '' || (row.dataset.pipeline || '') === status)
                   && (sektor === '' || (row.dataset.sektor || '').toLowerCase() === sektor);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    document.getElementById('row-count').textContent = visible + ' rekod';
    document.getElementById('empty-state').classList.toggle('hidden', visible > 0);
}

function set(id, text) { document.getElementById(id).textContent = text; }

function docBadge(el, submitted) {
    if (submitted) {
        el.className = 'status-badge bg-emerald-100 text-emerald-800 border-emerald-300 text-xs';
        el.innerHTML = '<span class="dot"></span>Dikemukakan';
    } else {
        el.className = 'status-badge bg-red-100 text-red-800 border-red-300 text-xs';
        el.innerHTML = '<span class="dot"></span>Tiada';
    }
}

function viewDetails(row) {
    const d  = row.dataset;
    const p  = PIPELINE_MAP[d.pipeline] || { label: d.pipeline, cls: 'status-badge bg-slate-100 text-slate-600 border-slate-300' };
    const waText = encodeURIComponent('Assalamualaikum ' + d.nama + ', kami dari Rahmah Consultancy Services ingin maklumkan status permohonan anda.');

    // Header
    set('modal-nama', d.nama);
    const pipelineEl = document.getElementById('modal-pipeline');
    pipelineEl.className = p.cls;
    pipelineEl.innerHTML = '<span class="dot"></span>' + p.label;

    // Section 1
    set('modal-tel',    d.telDisplay || d.tel);
    set('modal-emel',   d.emel   || '—');
    set('modal-daerah', d.daerah || '—');
    set('modal-poskod', d.poskod || '—');

    // Section 2
    set('modal-sektor',       d.sektorLabel || '—');
    set('modal-nama-majikan', d.namaMajikan || '—');
    set('modal-jawatan',      d.jawatan     || '—');
    set('modal-gaji',         d.gaji ? 'RM ' + Number(d.gaji).toLocaleString() : '—');
    set('modal-status-kerja', d.statusKerja || '—');

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

    // Section 3
    docBadge(document.getElementById('modal-slip-gaji'), d.slipGaji === '1');
    docBadge(document.getElementById('modal-ctos'),      d.ctos     === '1');
    docBadge(document.getElementById('modal-epf'),       d.epf      === '1');

    // Footer WA
    document.getElementById('modal-wa').href = 'https://wa.me/' + d.phone + '?text=' + waText;

    document.getElementById('details-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDetailsModal() {
    document.getElementById('details-modal').classList.add('hidden');
    document.body.style.overflow = '';
}

function printLead(d) {
    // Placeholder: wire to real PDF route when backend is ready
    alert('PDF untuk ' + d.nama + ' akan dijana apabila backend disambungkan.');
}

function deleteLead(btn) {
    const row = btn.closest('tr');
    const nama = row.dataset.nama;
    if (!confirm('Padam rekod ' + nama + '?\n\nTindakan ini tidak boleh dibatalkan.')) return;
    row.style.transition = 'opacity 0.2s';
    row.style.opacity = '0';
    setTimeout(() => { row.remove(); filterTable(); }, 200);
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.pipeline-select').forEach(applySelectStyle);
    const total = document.querySelectorAll('#permohonan-body .table-row').length;
    document.getElementById('row-count').textContent = total + ' rekod';
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeDetailsModal();
});
</script>

@endsection
