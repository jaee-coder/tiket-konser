@extends('admin.layouts.app')

@section('title', 'Laporan Tiket')

@section('content')
<h1 class="text-2xl font-bold mb-6">Laporan Penjualan Tiket</h1>

<div class="bg-white rounded-xl shadow p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm text-gray-600">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm text-gray-600">Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-sm text-gray-600">Status</label>
            <select name="status" class="border rounded px-3 py-2">
                <option value="">Semua</option>
                <option value="paid" @selected(request('status')=='paid')>Paid</option>
                <option value="booking" @selected(request('status')=='booking')>Booking</option>
            </select>
        </div>
        <div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Filter</button>
        </div>
        <div>
            <a href="{{ route('admin.laporan.export', request()->query()) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"><i class="fas fa-file-pdf mr-1"></i> Export PDF</a>
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left">Kode Tiket</th>
                    <th class="px-6 py-3 text-left">Konser</th>
                    <th class="px-6 py-3 text-left">Customer</th>
                    <th class="px-6 py-3 text-left">Harga</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($laporan as $tiket)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3 text-sm font-mono">{{ $tiket->kode_tiket }}</td>
                    <td class="px-6 py-3">{{ $tiket->konser->nama_concert ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $tiket->customer->name ?? '-' }}</td>
                    <td class="px-6 py-3">Rp {{ number_format($tiket->harga_jual,0,',','.') }}</td>
                    <td class="px-6 py-3">
                        @if($tiket->status == 'paid')
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Lunas</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Booking</span>
                        @endif
                    </td>
                    <td class="px-6 py-3">{{ $tiket->created_at->format('d-m-Y H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-6 text-gray-400">Tidak ada data tiket.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">
        {{ $laporan->appends(request()->query())->links() }}
    </div>
    <div class="p-4 border-t bg-gray-50 font-bold text-gray-800">
        Total Pendapatan: Rp {{ number_format($totalPendapatan,0,',','.') }}
    </div>
</div>
@endsection