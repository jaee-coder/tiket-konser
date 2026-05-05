@extends('admin.layouts.app')

@section('title', 'Venue')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Manajemen Venue</h1>
    <a href="{{ route('admin.venues.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">
        <i class="fas fa-plus mr-1"></i> Tambah Venue
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Venue</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alamat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kapasitas</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($venues as $venue)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">{{ $venue->id_venue }}</td>
                    <td class="px-6 py-4 font-medium">{{ $venue->nama_venue }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $venue->alamat ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $venue->kapasitas }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.venues.edit', $venue->id_venue) }}" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-edit"></i> Edit</a>
                        <a href="{{ route('admin.venues.generate-seats', $venue->id_venue) }}" class="text-green-600 hover:text-green-800"><i class="fas fa-chair"></i> Generate Kursi</a>
                        <form action="{{ route('admin.venues.destroy', $venue->id_venue) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus venue ini? Semua konser dan kursi terkait akan terhapus.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 ml-2"><i class="fas fa-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection