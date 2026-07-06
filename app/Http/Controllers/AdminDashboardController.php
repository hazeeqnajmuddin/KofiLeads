<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Prospect;

class AdminDashboardController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function index()
    {
        $stats = [
            'jumlah'    => 250,
            'pending'   => 50,
            'approved'  => 140,
            'rejected'  => 60,
        ];

        $recent = [
            ['nama' => 'Zulkifli Hassan',       'sektor' => 'Pesara', 'majikan' => 'Pesara Kerajaan',        'status' => 'pending',  'tarikh' => '2 Jul 2026'],
            ['nama' => 'Ahmad Albab',           'sektor' => 'Swasta', 'majikan' => 'Syarikat ABC',           'status' => 'pending',  'tarikh' => '1 Jul 2026'],
            ['nama' => 'Khairul Anwar Othman',  'sektor' => 'Awam',   'majikan' => 'Polis DiRaja Malaysia',  'status' => 'approved', 'tarikh' => '30 Jun 2026'],
            ['nama' => 'Nurul Ain Zainudin',    'sektor' => 'Awam',   'majikan' => 'Hospital Kuala Lumpur',  'status' => 'pending',  'tarikh' => '29 Jun 2026'],
            ['nama' => 'Siti Nurdiana',         'sektor' => 'Awam',   'majikan' => 'Kementerian Pendidikan', 'status' => 'approved', 'tarikh' => '28 Jun 2026'],
            ['nama' => 'Mohd Faizal bin Hamid', 'sektor' => 'Swasta', 'majikan' => 'Logistik Jaya Sdn Bhd',  'status' => 'rejected', 'tarikh' => '27 Jun 2026'],
        ];

        $summary = [
            'lead_hari_ini'         => 3,
            'lead_minggu_ini'       => 18,
            'lead_bulan_ini'        => 67,
            'dokumen_lengkap'       => 142,
            'dokumen_belum_lengkap' => 108,
            'layak'                 => 89,
            'approved'              => 140,
            'disbursed'             => 95,
        ];

        return view('admin.dashboard', compact('stats', 'recent', 'summary'));
    }

    public function permohonan(Request $request)
    {
        $prospects = collect([]);
        return view('admin.permohonan', compact('prospects'));
    }

    public function laporan()
    {
        return view('admin.laporan');
    }

    public function landing()
    {
        return view('admin.landing');
    }
}
