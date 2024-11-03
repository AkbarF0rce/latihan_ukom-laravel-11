<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Fungsi index untuk tampilkan halaman dashboard
    public function index()
    {
        return view('dashboard.index');
    }
}
