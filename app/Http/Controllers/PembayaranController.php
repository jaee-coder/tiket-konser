<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    // Menampilkan halaman pembayaran
    public function show($id_ticket)
    {
        $tiket = Tiket::with(['konser.venue', 'customer'])
                      ->where('id_customer', Auth::id())
                      ->where('status', 'booking')
                      ->findOrFail($id_ticket);

        return view('pembayaran.show', compact('tiket'));
    }

    // Proses pembayaran simulasi
    public function store(Request $request, $id_ticket)
    {
        $tiket = Tiket::where('id_customer', Auth::id())
                      ->where('status', 'booking')
                      ->findOrFail($id_ticket);

        $pembayaran = Pembayaran::create([
            'metode_pembayaran'  => $request->metode ?? 'Simulasi',
            'jumlah'             => $tiket->harga_jual,
            'tanggal_pembayaran' => now(),
            'status_pembayaran'  => 'lunas',
        ]);

        $tiket->update([
            'id_payment' => $pembayaran->id_payment,
            'status'     => 'paid',
        ]);

        return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil! Tiket Anda aktif.');
    }
}