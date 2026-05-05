@extends('admin.layouts.app')

@section('title', 'Tambah Konser Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Tambah Konser Baru</h1>

    <form method="POST" action="{{ route('admin.konsers.store') }}">
        @csrf

        <div class="mb-4">
            <label for="nama_concert" class="block text-gray-700 font-medium mb-1">Nama Konser <span class="text-red-500">*</span></label>
            <input type="text" name="nama_concert" id="nama_concert" value="{{ old('nama_concert') }}" required
                   class="w-full border rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('nama_concert') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="tanggal" class="block text-gray-700 font-medium mb-1">Tanggal <span class="text-red-500">*</span></label>
            <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" required
                   class="w-full border rounded-lg px-3 py-2">
            @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="waktu" class="block text-gray-700 font-medium mb-1">Waktu <span class="text-red-500">*</span></label>
            <input type="time" name="waktu" id="waktu" value="{{ old('waktu') }}" required
                   class="w-full border rounded-lg px-3 py-2">
            @error('waktu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="harga_dasar" class="block text-gray-700 font-medium mb-1">Harga Dasar (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="harga_dasar" id="harga_dasar" value="{{ old('harga_dasar') }}" required min="0" step="1000"
                   class="w-full border rounded-lg px-3 py-2">
            @error('harga_dasar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="id_venue" class="block text-gray-700 font-medium mb-1">Venue <span class="text-red-500">*</span></label>
            <select name="id_venue" id="id_venue" required class="w-full border rounded-lg px-3 py-2">
                <option value="">-- Pilih Venue --</option>
                @foreach($venues as $venue)
                    <option value="{{ $venue->id_venue }}" {{ old('id_venue') == $venue->id_venue ? 'selected' : '' }}>
                        {{ $venue->nama_venue }}
                    </option>
                @endforeach
            </select>
            @error('id_venue') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.konsers.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">Simpan</button>
        </div>
    </form>
</div>
@endsection