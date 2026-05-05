<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\Konser;
use App\Models\Tiket;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVenue  = Venue::count();
        $totalKonser = Konser::count();
        $totalTiket  = Tiket::count();
        $totalUser   = User::count();
        $pendapatan  = Tiket::where('status', 'paid')->sum('harga_jual');
        $tiketsTerjual = Tiket::where('status', 'paid')->count();

        return view('admin.dashboard', compact(
            'totalVenue', 'totalKonser', 'totalTiket', 'totalUser',
            'pendapatan', 'tiketsTerjual'
        ));
    }
}