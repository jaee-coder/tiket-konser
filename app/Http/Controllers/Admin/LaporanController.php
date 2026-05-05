<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan tiket dengan filter
     */
    public function tiket(Request $request)
    {
        $query = Tiket::with(['konser', 'customer'])->orderBy('created_at', 'desc');

        // Filter tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $laporan = $query->paginate(20);
        $totalPendapatan = Tiket::where('status', 'paid')->sum('harga_jual');

        return view('admin.laporan.tiket', compact('laporan', 'totalPendapatan'));
    }

    /**
     * Export laporan ke PDF
     */
    public function exportPDF(Request $request)
    {
        // Ambil data dengan filter yang sama
        $query = Tiket::with(['konser', 'customer'])->orderBy('created_at', 'desc');

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $laporan = $query->get();
        $totalPendapatan = $laporan->where('status', 'paid')->sum('harga_jual');
        $tanggalCetak = now()->format('d-m-Y H:i:s');

        // Load view untuk PDF
        $pdf = Pdf::loadView('admin.laporan.tiket_pdf', compact('laporan', 'totalPendapatan', 'tanggalCetak'));
        $pdf->setPaper('A4', 'landscape');

        // Download file PDF
        return $pdf->download('laporan_tiket_' . date('Ymd_His') . '.pdf');
    }
}