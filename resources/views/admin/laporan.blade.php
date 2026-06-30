@extends('layouts.admin')

@section('title', 'Laporan')
@section('page_title', 'Laporan')
@section('page_subtitle', 'Analisis dan pecahan data permohonan')

@section('admin_content')

<!-- Summary cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    @php
    $items = [
        ['label' => 'Jumlah Permohonan', 'val' => 0, 'sub' => 'Semua masa'],
        ['label' => 'Kadar Kelulusan',   'val' => '0%', 'sub' => 'Daripada jumlah diproses'],
        ['label' => 'Sektor Awam',        'val' => 0, 'sub' => 'Permohonan'],
        ['label' => 'Sektor Swasta',      'val' => 0, 'sub' => 'Permohonan'],
    ];
    @endphp

    @foreach($items as $item)
    <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">{{ $item['label'] }}</p>
        <p class="text-3xl font-bold text-slate-800">{{ $item['val'] }}</p>
        <p class="text-xs text-slate-400 mt-1">{{ $item['sub'] }}</p>
    </div>
    @endforeach

</div>

<!-- Breakdown by sector -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 text-sm mb-5">Pecahan Mengikut Sektor</h3>
        <div class="space-y-4">
            @php
            $sectors = [
                ['name' => 'Sektor Awam',    'count' => 0, 'pct' => 0,  'color' => 'bg-navy'],
                ['name' => 'Sektor Swasta',  'count' => 0, 'pct' => 0,  'color' => 'bg-gold'],
                ['name' => 'Bekerja Sendiri','count' => 0, 'pct' => 0,  'color' => 'bg-emerald-500'],
                ['name' => 'Pesara',          'count' => 0, 'pct' => 0, 'color' => 'bg-slate-400'],
            ];
            @endphp
            @foreach($sectors as $s)
            <div>
                <div class="flex justify-between text-xs text-slate-600 mb-1.5">
                    <span class="font-medium">{{ $s['name'] }}</span>
                    <span class="text-slate-400">{{ $s['count'] }} ({{ $s['pct'] }}%)</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="{{ $s['color'] }} h-full rounded-full transition-all" style="width: {{ $s['pct'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
        <h3 class="font-semibold text-slate-800 text-sm mb-5">Pecahan Mengikut Status</h3>
        <div class="space-y-4">
            @php
            $statuses = [
                ['name' => 'Menunggu',    'count' => 0, 'pct' => 0, 'color' => 'bg-amber-400'],
                ['name' => 'Diluluskan',  'count' => 0, 'pct' => 0, 'color' => 'bg-emerald-500'],
                ['name' => 'Ditolak',     'count' => 0, 'pct' => 0, 'color' => 'bg-red-500'],
            ];
            @endphp
            @foreach($statuses as $s)
            <div>
                <div class="flex justify-between text-xs text-slate-600 mb-1.5">
                    <span class="font-medium">{{ $s['name'] }}</span>
                    <span class="text-slate-400">{{ $s['count'] }} ({{ $s['pct'] }}%)</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="{{ $s['color'] }} h-full rounded-full transition-all" style="width: {{ $s['pct'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>

<!-- Monthly trend placeholder -->
<div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
    <h3 class="font-semibold text-slate-800 text-sm mb-1">Trend Bulanan</h3>
    <p class="text-xs text-slate-400 mb-6">Jumlah permohonan diterima setiap bulan</p>
    <div class="h-36 flex items-end gap-2">
        @foreach(['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ogo','Sep','Okt','Nov','Dis'] as $month)
        <div class="flex-1 flex flex-col items-center gap-1">
            <div class="w-full bg-slate-100 rounded-t" style="height: 8px"></div>
            <span class="text-[9px] text-slate-400">{{ $month }}</span>
        </div>
        @endforeach
    </div>
    <p class="text-center text-xs text-slate-300 mt-4">Data akan dipaparkan apabila terdapat rekod permohonan</p>
</div>

@endsection
