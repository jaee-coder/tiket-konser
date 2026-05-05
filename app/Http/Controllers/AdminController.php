<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use App\Models\Konser;
use App\Models\Kursi;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Middleware agar hanya admin yang bisa akses (sesuaikan)
     */
    public function __construct()
    {
        $this->middleware('auth');
        // Tambahkan pengecekan role admin jika diperlukan
    }

    // Daftar venue
    public function venues()
    {
        $venues = Venue::all();
        return view('admin.venues', compact('venues'));
    }

    // Form tambah venue
    public function createVenue()
    {
        return view('admin.venue_create');
    }

    // Simpan venue
    public function storeVenue(Request $request)
    {
        $request->validate([
            'nama_venue' => 'required|string|max:100',
            'alamat'     => 'nullable|string',
            'kapasitas'  => 'required|integer|min:1',
        ]);

        Venue::create($request->all());
        return redirect()->route('admin.venues')->with('success', 'Venue berhasil ditambahkan.');
    }

    // Daftar konser
    public function konsers()
    {
        $konsers = Konser::with('venue')->get();
        return view('admin.konsers', compact('konsers'));
    }

    // Form tambah konser
    public function createKonser()
    {
        $venues = Venue::all();
        return view('admin.konser_create', compact('venues'));
    }

    // Simpan konser
    public function storeKonser(Request $request)
    {
        $request->validate([
            'nama_concert' => 'required|string|max:100',
            'tanggal'      => 'required|date',
            'waktu'        => 'required',
            'harga_dasar'  => 'required|numeric|min:0',
            'id_venue'     => 'required|exists:venues,id_venue',
        ]);

        Konser::create($request->all());
        return redirect()->route('admin.konsers')->with('success', 'Konser berhasil ditambahkan.');
    }

    // Generate kursi untuk venue tertentu (opsional)
    public function generateSeats($id_venue)
    {
        $venue = Venue::findOrFail($id_venue);
        // Contoh generate kursi A1-A10, B1-B10, C1-C10
        $baris = ['A', 'B', 'C'];
        $tipeSeat = ['reguler', 'vip', 'vip'];

        for ($i = 0; $i < 3; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                Kursi::updateOrCreate(
                    [
                        'id_venue'    => $venue->id_venue,
                        'nomor_kursi' => $baris[$i] . $j
                    ],
                    [
                        'baris'       => $baris[$i],
                        'tipe_kursi'  => $tipeSeat[$i],
                        'status'      => 'available'
                    ]
                );
            }
        }

        return redirect()->back()->with('success', 'Kursi berhasil digenerate.');
    }
}