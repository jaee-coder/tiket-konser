<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Tiket milik user yang login
        $tikets = Tiket::with(['konser.venue'])
                       ->where('id_customer', $user->id)
                       ->orderBy('created_at', 'desc')
                       ->get();

        // Daftar orang yang direfer oleh user ini
        $referrals = $user->referrals;

        return view('dashboard', compact('tikets', 'referrals'));
    }
}