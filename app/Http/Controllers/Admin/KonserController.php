<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konser;
use App\Models\Venue;
use Illuminate\Http\Request;

class KonserController extends Controller
{
    public function index()
    {
        $konsers = Konser::with('venue')->orderBy('tanggal', 'desc')->get();
        return view('admin.konsers.index', compact('konsers'));
    }

    public function create()
    {
        $venues = Venue::all();
        return view('admin.konsers.create', compact('venues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_concert' => 'required|string|max:100',
            'tanggal'      => 'required|date',
            'waktu'        => 'required',
            'harga_dasar'  => 'required|numeric|min:0',
            'id_venue'     => 'required|exists:venues,id_venue',
        ]);

        Konser::create($request->all());
        return redirect()->route('admin.konsers.index')
            ->with('success', 'Konser berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $konser = Konser::findOrFail($id);
        $venues = Venue::all();
        return view('admin.konsers.edit', compact('konser', 'venues'));
    }

    public function update(Request $request, $id)
    {
        $konser = Konser::findOrFail($id);
        $request->validate([
            'nama_concert' => 'required|string|max:100',
            'tanggal'      => 'required|date',
            'waktu'        => 'required',
            'harga_dasar'  => 'required|numeric|min:0',
            'id_venue'     => 'required|exists:venues,id_venue',
        ]);
        $konser->update($request->all());
        return redirect()->route('admin.konsers.index')
            ->with('success', 'Konser berhasil diupdate.');
    }

    public function destroy($id)
    {
        $konser = Konser::findOrFail($id);
        $konser->delete();
        return redirect()->route('admin.konsers.index')
            ->with('success', 'Konser berhasil dihapus.');
    }
}