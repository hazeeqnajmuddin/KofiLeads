<?php

namespace App\Http\Controllers;

use App\Models\Lead;

class AdminDashboardController extends Controller
{
    /** Sektor label map (4 canonical values). */
    private const SEKTOR_LABELS = [
        'kerajaan' => 'Kerajaan',
        'glc' => 'GLC',
        'berkanun' => 'Badan Berkanun',
        'swasta' => 'Swasta',
    ];

    public function showLogin()
    {
        return view('admin.login');
    }

    public function index()
    {
        $counts = Lead::query()
            ->selectRaw('pipeline_status, COUNT(*) as c')
            ->groupBy('pipeline_status')
            ->pluck('c', 'pipeline_status');

        $total = (int) $counts->sum();
        $layak = (int) ($counts['layak'] ?? 0);
        $tidakLayak = (int) ($counts['tidak_layak'] ?? 0);

        $stats = [
            'jumlah' => $total,
            'pending' => max(0, $total - $layak - $tidakLayak),
            'layak' => $layak,
            'tidak_layak' => $tidakLayak,
        ];

        $recent = Lead::query()
            ->latest('submitted_at')
            ->take(6)
            ->get()
            ->map(fn (Lead $lead) => [
                'nama' => $lead->nama,
                'sektor' => self::SEKTOR_LABELS[$lead->sektor] ?? $lead->sektor,
                'majikan' => $lead->nama_majikan,
                // Real pipeline status so the dashboard badge matches the Permohonan page.
                'status' => $lead->pipeline_status,
                'tarikh' => $lead->submitted_at?->format('j M Y') ?? '—',
            ])
            ->all();

        $summary = [
            'lead_hari_ini' => Lead::whereDate('submitted_at', today())->count(),
            'lead_minggu_ini' => Lead::where('submitted_at', '>=', now()->startOfWeek())->count(),
            'lead_bulan_ini' => Lead::where('submitted_at', '>=', now()->startOfMonth())->count(),
            'dokumen_lengkap' => (int) ($counts['dokumen_lengkap'] ?? 0),
            'dokumen_belum_lengkap' => (int) ($counts['dokumen_belum_lengkap'] ?? 0),
            'layak' => $layak,
        ];

        return view('admin.dashboard', compact('stats', 'recent', 'summary'));
    }

    // permohonan() moved to App\Http\Controllers\Admin\LeadController@index (Phase 4)
    // laporan()    moved to App\Http\Controllers\Admin\ReportController@index (Phase 6)
    // landing()    moved to App\Http\Controllers\Admin\SettingController@edit (Phase 5)
}
