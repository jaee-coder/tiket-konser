@extends('layouts.app')

@section('title', 'Pesan Tiket - ' . $konser->nama_concert)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header Konser -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white">
            <h1 class="text-2xl font-bold">{{ $konser->nama_concert }}</h1>
            <div class="flex flex-wrap gap-4 text-sm mt-2">
                <span><i class="fas fa-map-marker-alt"></i> {{ $konser->venue->nama_venue }}</span>
                <span><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($konser->tanggal)->format('d M Y, H:i') }}</span>
            </div>
        </div>

        <div class="p-6">
            <form method="POST" action="{{ route('tiket.store') }}" id="bookingForm">
                @csrf
                <input type="hidden" name="id_concert" value="{{ $konser->id_concert }}">
                <input type="hidden" name="nomor_kursi" id="selectedKursi" required>

                <!-- Jenis Tiket -->
                <div class="mb-6">
                    <label class="block font-semibold mb-2">Jenis Tiket</label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="border rounded-lg p-3 flex justify-between cursor-pointer hover:bg-indigo-50">
                            <div><span class="font-medium">Reguler</span><p class="text-sm text-gray-500">Standar</p></div>
                            <input type="radio" name="tipe" value="reguler" class="form-radio text-indigo-600" checked>
                        </label>
                        <label class="border rounded-lg p-3 flex justify-between cursor-pointer hover:bg-indigo-50">
                            <div><span class="font-medium">VIP</span><p class="text-sm text-gray-500">Akses eksklusif</p></div>
                            <input type="radio" name="tipe" value="vip" class="form-radio text-indigo-600">
                        </label>
                    </div>
                </div>

                <!-- Pilih Kursi (Hanya yang available) -->
                <div class="mb-6">
                    <label class="block font-semibold mb-2">Pilih Kursi <span class="text-red-500">*</span></label>
                    <div class="bg-gray-50 p-4 rounded-lg border">
                        <div class="grid grid-cols-6 gap-2 max-h-64 overflow-y-auto">
                            @forelse($konser->venue->kursis as $kursi)
                                @if($kursi->status == 'available')
                                    <div class="kursi-item bg-white border border-gray-300 text-center py-2 rounded-md cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition"
                                         data-kursi="{{ $kursi->nomor_kursi }}">
                                        {{ $kursi->nomor_kursi }}
                                    </div>
                                @else
                                    <div class="bg-gray-200 text-gray-400 text-center py-2 rounded-md cursor-not-allowed opacity-60"
                                         title="Sudah dipesan">
                                        {{ $kursi->nomor_kursi }}
                                    </div>
                                @endif
                            @empty
                                <div class="col-span-full text-center py-4 text-gray-500">
                                    Tidak ada kursi tersedia untuk konser ini.
                                </div>
                            @endforelse
                        </div>
                        <p class="text-xs text-gray-500 mt-2"><i class="fas fa-info-circle"></i> Klik pada kursi putih untuk memilih.</p>
                    </div>
                </div>

                <!-- Jumlah (maks 1) -->
                <div class="mb-6">
                    <label class="block font-semibold mb-2">Jumlah Tiket</label>
                    <input type="number" name="jumlah" id="jumlah" min="1" max="1" value="1" class="w-32 border rounded px-3 py-2">
                    <p class="text-xs text-gray-500">* Hanya 1 tiket per transaksi.</p>
                </div>

                <!-- Total Harga -->
                <div class="border-t pt-4 flex justify-between items-center">
                    <span class="font-semibold">Total yang harus dibayar:</span>
                    <span id="totalPrice" class="text-2xl font-bold text-indigo-600">Rp 0</span>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow transition">
                        Lanjut ke Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Harga dasar
    const hargaDasar = {{ $konser->harga_dasar }};
    const radioReguler = document.querySelector('input[value="reguler"]');
    const radioVip = document.querySelector('input[value="vip"]');
    const jumlahInput = document.getElementById('jumlah');
    const totalSpan = document.getElementById('totalPrice');

    function updateTotal() {
        let harga = radioVip.checked ? hargaDasar + 200000 : hargaDasar;
        let jumlah = parseInt(jumlahInput.value) || 1;
        if (jumlah > 1) jumlahInput.value = 1;
        let total = harga * (jumlah > 1 ? 1 : jumlah);
        totalSpan.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    radioReguler.addEventListener('change', updateTotal);
    radioVip.addEventListener('change', updateTotal);
    jumlahInput.addEventListener('input', updateTotal);
    updateTotal();

    // Pemilihan kursi
    const kursiItems = document.querySelectorAll('.kursi-item');
    const selectedInput = document.getElementById('selectedKursi');
    let selectedDom = null;

    kursiItems.forEach(item => {
        item.addEventListener('click', function() {
            if (selectedDom) {
                selectedDom.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                selectedDom.classList.add('bg-white', 'border-gray-300');
            }
            this.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
            selectedDom = this;
            selectedInput.value = this.dataset.kursi;
        });
    });

    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        if (!selectedInput.value) {
            e.preventDefault();
            alert('Pilih kursi terlebih dahulu!');
        }
    });
</script>
@endsection