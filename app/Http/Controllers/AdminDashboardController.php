<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Prospect;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'jumlah'    => 0,
            'pending'   => 0,
            'approved'  => 0,
            'rejected'  => 0,
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function permohonan(Request $request)
    {
        $prospects = collect([]); // Replace with Prospect::query()->filter($request)->latest()->get()
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
