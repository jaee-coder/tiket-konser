<?php

namespace App\Http\Controllers;

use App\Models\Konser;
use Illuminate\Http\Request;

class KonserController extends Controller
{
    /**
     * Tampilkan daftar konser yang akan datang (halaman home)
     */
    public function index()
    {
        // Ambil 6 konser dengan tanggal > sekarang, urut dari terdekat
        $konsers = Konser::with('venue')
                        ->where('tanggal', '<', now())
                        ->orderBy('tanggal', 'asc')
                        ->take(6)
                        ->get();

        return view('konser.index', compact('konsers'));
    }

    /**
     * (Opsional) Detail konser tertentu
     */
    public function show($id)
    {
        $konser = Konser::with('venue.kursis')->findOrFail($id);
        return view('konser.show', compact('konser'));
    }
}