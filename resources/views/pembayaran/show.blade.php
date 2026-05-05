@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-lg mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 text-white text-center">
                <i class="fas fa-credit-card text-5xl mb-2"></i>
                <h1 class="text-2xl font-bold">Konfirmasi Pembayaran</h1>
                <p class="text-sm opacity-90">Klik tombol di bawah untuk menyelesaikan pembayaran</p>
            </div>
            <div class="p-6">
                <!-- Detail Tiket -->
                <div class="border rounded-lg p-4 mb-6 bg-gray-50">
                    <h2 class="font-semibold text-gray-700 mb-3">Detail Tiket</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">Konser:</span><span class="font-medium">{{ $tiket->konser->nama_concert }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Venue:</span><span>{{ $tiket->konser->venue->nama_venue }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Tanggal:</span><span>{{ \Carbon\Carbon::parse($tiket->konser->tanggal)->format('d M Y, H:i') }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Kursi:</span><span class="font-mono">{{ $tiket->nomor_kursi }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Jenis:</span><span class="capitalize">{{ $tiket->tipe }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Kode Tiket:</span><code class="bg-gray-200 px-1 rounded text-xs">{{ $tiket->kode_tiket }}</code></div>
                    </div>
                </div>

                <!-- Total Harga -->
                <div class="bg-indigo-50 rounded-lg p-4 mb-6 text-center">
                    <span class="text-gray-600">Total yang harus dibayar:</span>
                    <div class="text-3xl font-bold text-indigo-600">Rp {{ number_format($tiket->harga_jual, 0, ',', '.') }}</div>
                </div>

                <!-- Form Bayar -->
                <form method="POST" action="{{ route('pembayaran.store', $tiket->id_ticket) }}">
                    @csrf
                    <input type="hidden" name="metode" value="Simulasi">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition shadow">
                        Bayar Sekarang
                    </button>
                </form>
                <p class="text-xs text-gray-400 text-center mt-4">* Ini adalah simulasi pembayaran. Tidak ada transaksi uang nyata.</p>
            </div>
        </div>
    </div>
</div>
@endsection