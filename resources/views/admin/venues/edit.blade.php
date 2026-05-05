@extends('admin.layouts.app')

@section('title', 'Edit Venue')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Edit Venue</h1>
    <form method="POST" action="{{ route('admin.venues.update', $venue->id_venue) }}">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Nama Venue <span class="text-red-500">*</span></label>
            <input type="text" name="nama_venue" value="{{ old('nama_venue', $venue->nama_venue) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Alamat</label>
            <textarea name="alamat" rows="3" class="w-full border rounded-lg px-3 py-2">{{ old('alamat', $venue->alamat) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-medium mb-1">Kapasitas <span class="text-red-500">*</span></label>
            <input type="number" name="kapasitas" value="{{ old('kapasitas', $venue->kapasitas) }}" required class="w-full border rounded-lg px-3 py-2">
        </div>
        <div class="flex justify-end space-x-2">
            <a href="{{ route('admin.venues.index') }}" class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-50">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">Update</button>
        </div>
    </form>
</div>
@endsection