@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-gray-500 text-sm">Total Venue</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalVenue ?? 0 }}</p>
        </div>
        <div class="bg-indigo-100 p-3 rounded-full"><i class="fas fa-building text-indigo-600 text-xl"></i></div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-gray-500 text-sm">Total Konser</p>
            <p class="text-3xl font-bold text-gray-800">{{ $totalKonser ?? 0 }}</p>
        </div>
        <div class="bg-purple-100 p-3 rounded-full"><i class="fas fa-music text-purple-600 text-xl"></i></div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-gray-500 text-sm">Tiket Terjual</p>
            <p class="text-3xl font-bold text-gray-800">{{ $tiketsTerjual ?? 0 }}</p>
        </div>
        <div class="bg-green-100 p-3 rounded-full"><i class="fas fa-ticket-alt text-green-600 text-xl"></i></div>
    </div>
    <div class="bg-white rounded-xl shadow p-6 flex justify-between items-center">
        <div>
            <p class="text-gray-500 text-sm">Pendapatan</p>
            <p class="text-3xl font-bold text-green-600">Rp {{ number_format($pendapatan ?? 0,0,',','.') }}</p>
        </div>
        <div class="bg-yellow-100 p-3 rounded-full"><i class="fas fa-money-bill-wave text-yellow-600 text-xl"></i></div>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h3 class="text-lg font-bold text-gray-700 mb-2">Selamat datang di Panel Admin</h3>
    <p class="text-gray-500">Kelola venue, konser, dan pantau penjualan tiket dengan mudah.</p>
</div>
@endsection