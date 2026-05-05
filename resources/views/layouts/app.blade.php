<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TiketKonser')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .seat-selected { background-color: #4f46e5 !important; color: white !important; border-color: #4f46e5 !important; }
        .transition-smooth { transition: all 0.2s ease-in-out; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navbar sticky blur -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="flex items-center space-x-2 text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    <i class="fas fa-ticket-alt text-indigo-500"></i>
                    <span>TiketKonser</span>
                </a>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 transition font-medium">Home</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-indigo-600 transition">Dashboard</a>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 font-semibold">Admin Panel</a>
                        @endif
                        <div class="relative group">
                            <button class="flex items-center space-x-1 text-gray-700 hover:text-indigo-600 focus:outline-none">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-indigo-600 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-700 transition">Daftar</a>
                    @endauth
                </div>
                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <a href="{{ route('home') }}" class="block py-2 text-gray-700">Home</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block py-2 text-gray-700">Dashboard</a>
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 text-indigo-600">Admin Panel</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left py-2 text-gray-700">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block py-2 text-indigo-600">Login</a>
                    <a href="{{ route('register') }}" class="block py-2 bg-indigo-600 text-white text-center rounded-full">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="container mx-auto px-4 mt-4"><div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded">{{ session('success') }}</div></div>
    @endif
    @if(session('error'))
        <div class="container mx-auto px-4 mt-4"><div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded">{{ session('error') }}</div></div>
    @endif

    <main class="py-8">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 mt-12 text-center text-gray-500 text-sm">
        &copy; {{ date('Y') }} TiketKonser. All rights reserved.
    </footer>

    <script>
        const menuBtn = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        if(menuBtn) menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
    </script>
    @stack('styles')
    @stack('scripts')

</body>
</html>