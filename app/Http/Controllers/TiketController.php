<?php

namespace App\Http\Controllers;

use App\Models\Konser;
use App\Models\Tiket;
use App\Models\Kursi;
use App\Models\TiketReguler;
use App\Models\TiketVIP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TiketController extends Controller
{
    // Menampilkan form pemesanan tiket
    public function create($id_concert)
    {
        $konser = Konser::with(['venue.kursis' => function ($query) {
            $query->where('status', 'available'); // hanya tampilkan kursi available
        }])->findOrFail($id_concert);

        return view('tiket.create', compact('konser'));
    }

    // Menyimpan pemesanan
    public function store(Request $request)
{
    // Validasi
    $request->validate([
        'id_concert'  => 'required|exists:konsers,id_concert',
        'tipe'        => 'required|in:reguler,vip',
        'nomor_kursi' => 'required|string',
        'jumlah'      => 'required|integer|min:1|max:1',
    ]);

    $konser = Konser::findOrFail($request->id_concert);
    $nomorKursi = $request->nomor_kursi;

    // Cek ketersediaan kursi
    $kursi = Kursi::where('id_venue', $konser->id_venue)
                  ->where('nomor_kursi', $nomorKursi)
                  ->where('status', 'available')
                  ->first();

    if (!$kursi) {
        return redirect()->back()->withErrors(['kursi' => 'Kursi tidak tersedia.'])->withInput();
    }

    // Hitung harga
    $harga = ($request->tipe == 'vip') ? $konser->harga_dasar + 200000 : $konser->harga_dasar;
    $kodeTiket = 'TIX' . time() . rand(100, 999);

    // Simpan tiket
    $tiket = Tiket::create([
        'kode_tiket'        => $kodeTiket,
        'status'            => 'booking',
        'tanggal_pembelian' => now(),
        'harga_jual'        => $harga,
        'id_concert'        => $konser->id_concert,
        'id_customer'       => Auth::id(),
        'id_payment'        => null,
        'tipe'              => $request->tipe,
        'nomor_kursi'       => $nomorKursi,
    ]);

    // Subclass
    if ($request->tipe == 'reguler') {
        TiketReguler::create(['id_ticket' => $tiket->id_ticket, 'zona' => 'Utara']);
    } else {
        TiketVIP::create(['id_ticket' => $tiket->id_ticket, 'akses_vip' => 'Backstage', 'fasilitas_tambahan' => 'Makanan']);
    }

    // *** HANYA UPDATE SATU KURSI ***
    Kursi::where('id_venue', $konser->id_venue)
         ->where('nomor_kursi', $nomorKursi)
         ->update(['status' => 'booked']);

    return redirect()->route('pembayaran.show', $tiket->id_ticket)
                     ->with('success', 'Tiket berhasil dipesan! Silakan bayar.');
}
}