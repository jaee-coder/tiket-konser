<?php

use App\Http\Controllers\KonserController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\VenueController as AdminVenue;
use App\Http\Controllers\Admin\KonserController as AdminKonser;
use App\Http\Controllers\Admin\LaporanController as AdminLaporan;
use Illuminate\Support\Facades\Route;

Route::get('/', [KonserController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/konser/{id_concert}/pesan', [TiketController::class, 'create'])->name('tiket.create');
    Route::post('/tiket', [TiketController::class, 'store'])->name('tiket.store');
    Route::get('/pembayaran/{id_ticket}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{id_ticket}', [PembayaranController::class, 'store'])->name('pembayaran.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('venues', AdminVenue::class);
    Route::get('venues/{id}/generate-seats', [AdminVenue::class, 'generateSeats'])->name('venues.generate-seats');
    Route::resource('konsers', AdminKonser::class);
    Route::get('laporan/tiket', [AdminLaporan::class, 'tiket'])->name('laporan.tiket');
    Route::get('laporan/export', [AdminLaporan::class, 'exportPDF'])->name('laporan.export');
});

require __DIR__.'/auth.php';