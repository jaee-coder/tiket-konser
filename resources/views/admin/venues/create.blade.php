@extends('admin.layouts.app')

@section('title', 'Tambah Venue')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Tambah Venue Baru</h1>
    <form method="POST" action="{{ route('admin.venues.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nama Venue <span class="text-red-500">*</span></label>
            <input type="text" name="nama_venue" value="{{ old('nama_venue') }}" required class="w-full border rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            @error('nama_venue') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Alamat</label>
            <textarea name="alamat" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('alamat') }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Kapasitas <span class="text-red-500">*</span></label>
            <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" required class="w-full border rounded-lg px-3 py-2">
            @error('kapasitas') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.venues.index') }}" class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Simpan</button>
        </div>
    </form>
</div>
@endsection