<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Prospect; // Uncomment this when you create your Prospect model

class AdminDashboardController extends Controller
{
    public function index()
    {
        // For now, passing empty arrays until your backend logic/database tables are built.
        // Once ready, you'll fetch records like: $prospects = Prospect::latest()->get();
        return view('admin.dashboard', [
            'prospects' => [] 
        ]);
    }
}