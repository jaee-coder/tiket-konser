<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use App\Models\Kursi;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        $venues = Venue::orderBy('id_venue', 'desc')->get();
        return view('admin.venues.index', compact('venues'));
    }

    public function create()
    {
        return view('admin.venues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_venue' => 'required|string|max:100',
            'alamat'     => 'nullable|string',
            'kapasitas'  => 'required|integer|min:1',
        ]);

        Venue::create($request->all());
        return redirect()->route('admin.venues.index')
            ->with('success', 'Venue berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $venue = Venue::findOrFail($id);
        return view('admin.venues.edit', compact('venue'));
    }

    public function update(Request $request, $id)
    {
        $venue = Venue::findOrFail($id);
        $request->validate([
            'nama_venue' => 'required|string|max:100',
            'alamat'     => 'nullable|string',
            'kapasitas'  => 'required|integer|min:1',
        ]);
        $venue->update($request->all());
        return redirect()->route('admin.venues.index')
            ->with('success', 'Venue berhasil diupdate.');
    }

    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();
        return redirect()->route('admin.venues.index')
            ->with('success', 'Venue berhasil dihapus.');
    }

    // Generate kursi untuk venue
    public function generateSeats($id)
{
    $venue = Venue::findOrFail($id);
    
    // Hapus kursi lama jika ingin regenerate (opsional)
    // Kursi::where('id_venue', $id)->delete();
    
    $rows = ['A', 'B', 'C', 'D', 'E'];
    $seatsPerRow = ceil($venue->kapasitas / count($rows));
    $created = 0;
    
    foreach ($rows as $i => $row) {
        for ($j = 1; $j <= $seatsPerRow; $j++) {
            if ($created >= $venue->kapasitas) break;
            $seatNumber = $row . $j;
            Kursi::updateOrCreate(
                ['id_venue' => $id, 'nomor_kursi' => $seatNumber],
                [
                    'baris'      => $row,
                    'tipe_kursi' => ($i < 2) ? 'vip' : 'reguler',
                    'status'     => 'available',
                ]
            );
            $created++;
        }
        if ($created >= $venue->kapasitas) break;
    }
    
    return redirect()->back()->with('success', "Berhasil generate {$created} kursi untuk venue {$venue->nama_venue}.");
}
}