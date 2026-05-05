@extends('layouts.app')

@section('title', 'TiketKonser - Beli Tiket Konser Favoritmu')

@section('content')
<!-- Hero Slider (manual) -->
<div class="relative bg-gradient-to-r from-indigo-900 to-purple-800 text-white py-20 md:py-28 overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-40"></div>
    <div class="relative container mx-auto px-6 text-center z-10">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 animate-fade-in-down">Pengalaman Konser Tak Terlupakan</h1>
            <p class="text-lg md:text-xl mb-8 opacity-90 animate-fade-in-up">Dapatkan tiket konser artis favorit Anda dengan harga terbaik. Booking sekarang, bayar mudah!</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up animation-delay-200">
                <a href="#concerts" class="bg-white text-indigo-700 hover:bg-gray-100 font-semibold px-6 py-3 rounded-full shadow-lg transition transform hover:-translate-y-1">
                    Lihat Konser <i class="fas fa-arrow-down ml-2"></i>
                </a>
                <a href="{{ route('register') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-indigo-700 font-semibold px-6 py-3 rounded-full transition">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
    <!-- Gelombang -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-12">
            <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" fill="white" opacity="0.8"></path>
        </svg>
    </div>
</div>

<!-- Daftar Konser dengan Filter -->
<div class="container mx-auto px-6 py-16" id="concerts">
    <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-4">Konser Mendatang</h2>
    <p class="text-center text-gray-600 mb-8">Jangan lewatkan momen spesial bersama idola Anda</p>

    <!-- Filter -->
    <div class="flex flex-wrap justify-center gap-4 mb-12">
        <button data-filter="all" class="filter-btn active bg-indigo-600 text-white px-5 py-2 rounded-full hover:bg-indigo-700 transition">Semua Konser</button>
        @php
            $uniqueVenues = $konsers->pluck('venue.nama_venue')->unique();
        @endphp
        @foreach($uniqueVenues as $venueName)
            <button data-filter="{{ Str::slug($venueName) }}" class="filter-btn bg-gray-200 text-gray-700 px-5 py-2 rounded-full hover:bg-gray-300 transition">{{ $venueName }}</button>
        @endforeach
    </div>

    @if($konsers->isEmpty())
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
            <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Belum ada konser mendatang. Silakan cek kembali nanti.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="konser-list">
            @foreach($konsers as $konser)
                @php
                    $availableSeats = $konser->venue->kursis->where('status', 'available')->count();
                @endphp
                <div class="konser-card group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" data-venue="{{ Str::slug($konser->venue->nama_venue) }}">
                    <div class="relative h-48 bg-gradient-to-r from-indigo-400 to-purple-500 flex items-center justify-center">
                        <i class="fas fa-microphone-alt text-white text-6xl opacity-50 group-hover:scale-110 transition-transform duration-300"></i>
                        <div class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                            H-{{ max(0, \Carbon\Carbon::parse($konser->tanggal)->diffInDays(now())) }}
                        </div>
                        @if($availableSeats < 10)
                            <div class="absolute bottom-4 left-4 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                Sisa {{ $availableSeats }} kursi
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $konser->nama_concert }}</h3>
                        <div class="space-y-2 text-gray-600 text-sm mb-4">
                            <p><i class="fas fa-map-marker-alt w-5 text-indigo-500"></i> {{ $konser->venue->nama_venue }}</p>
                            <p><i class="far fa-calendar-alt w-5 text-indigo-500"></i> {{ \Carbon\Carbon::parse($konser->tanggal)->format('d M Y, H:i') }}</p>
                            <p><i class="fas fa-tag w-5 text-indigo-500"></i> Mulai dari <span class="font-bold text-indigo-600">Rp {{ number_format($konser->harga_dasar, 0, ',', '.') }}</span></p>
                        </div>
                        <a href="{{ route('tiket.create', $konser->id_concert) }}" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-xl transition duration-200">
                            Pesan Tiket <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Jika konser lebih dari 6, bisa tambah tombol Load More (opsional) -->
    @endif
</div>

<!-- Section keunggulan (stats) -->
<div class="bg-gradient-to-r from-indigo-50 to-purple-50 py-16">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-indigo-600 mb-2">100+</div>
                <div class="text-gray-600">Konser Telah Digelar</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-indigo-600 mb-2">10.000+</div>
                <div class="text-gray-600">Tiket Terjual</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-indigo-600 mb-2">24/7</div>
                <div class="text-gray-600">Dukungan Pelanggan</div>
            </div>
        </div>
    </div>
</div>

<!-- Testimonial sederhana -->
<div class="container mx-auto px-6 py-16">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Apa Kata Mereka?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-indigo-600"></i></div>
                <div class="ml-3"><h4 class="font-semibold">Andi S.</h4><div class="text-yellow-400 text-sm">★★★★★</div></div>
            </div>
            <p class="text-gray-600">“Mudah memesan tiket, kursi langsung terpilih. Recommended!”</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <div class="flex items-center mb-4"><div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-indigo-600"></i></div><div class="ml-3"><h4 class="font-semibold">Sinta R.</h4><div class="text-yellow-400 text-sm">★★★★★</div></div></div>
            <p class="text-gray-600">“Proses cepat, tiket masuk dashboard langsung.”</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <div class="flex items-center mb-4"><div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-indigo-600"></i></div><div class="ml-3"><h4 class="font-semibold">Budi W.</h4><div class="text-yellow-400 text-sm">★★★★★</div></div></div>
            <p class="text-gray-600">“Dapat kode referral, jadi lebih hemat.”</p>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Animasi */
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down { animation: fadeInDown 0.8s ease-out; }
    .animate-fade-in-up { animation: fadeInUp 0.8s ease-out; }
    .animation-delay-200 { animation-delay: 0.2s; }
    .filter-btn.active {
        background-color: #4f46e5;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    // Filter konser berdasarkan venue
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const cards = document.querySelectorAll('.konser-card');
        
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const filterValue = this.dataset.filter;
                // Update active class
                filterBtns.forEach(b => b.classList.remove('active', 'bg-indigo-600', 'text-white'));
                this.classList.add('active', 'bg-indigo-600', 'text-white');
                this.classList.remove('bg-gray-200', 'text-gray-700');
                
                // Filter cards
                cards.forEach(card => {
                    if (filterValue === 'all') {
                        card.style.display = 'block';
                    } else {
                        if (card.dataset.venue === filterValue) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
            });
        });
    });
</script>
@endpush