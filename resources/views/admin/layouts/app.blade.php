<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin TiketKonser - @yield('title', 'Dashboard')</title>
    <!-- Tailwind CSS CDN + Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom transition for sidebar */
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex h-screen">
    <!-- SIDEBAR -->
    <aside class="w-64 bg-gradient-to-b from-indigo-800 to-indigo-900 text-white flex-shrink-0 hidden md:block shadow-xl">
        <div class="p-5 border-b border-indigo-700">
            <div class="flex items-center space-x-2">
                <i class="fas fa-ticket-alt text-2xl"></i>
                <span class="text-xl font-bold">Admin Panel</span>
            </div>
            <p class="text-indigo-200 text-xs mt-1">TiketKonser Management</p>
        </div>
        <nav class="mt-5 px-2">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-700' : '' }}">
                <i class="fas fa-tachometer-alt w-5 mr-2"></i> Dashboard
            </a>
            <a href="{{ route('admin.venues.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 {{ request()->routeIs('admin.venues.*') ? 'bg-indigo-700' : '' }}">
                <i class="fas fa-building w-5 mr-2"></i> Venue
            </a>
            <a href="{{ route('admin.konsers.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 {{ request()->routeIs('admin.konsers.*') ? 'bg-indigo-700' : '' }}">
                <i class="fas fa-music w-5 mr-2"></i> Konser
            </a>
            <a href="{{ route('admin.laporan.tiket') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 {{ request()->routeIs('admin.laporan.*') ? 'bg-indigo-700' : '' }}">
                <i class="fas fa-chart-line w-5 mr-2"></i> Laporan Tiket
            </a>
        </nav>
        <div class="absolute bottom-0 w-64 p-4 border-t border-indigo-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full text-indigo-200 hover:text-white">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top navbar -->
        <header class="bg-white shadow-sm sticky top-0 z-10">
            <div class="px-6 py-3 flex justify-between items-center">
                <div class="flex items-center md:hidden">
                    <button id="sidebarToggle" class="text-gray-600 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 text-sm">{{ Auth::user()->name }}</span>
                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                        <span class="text-indigo-600 font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-6 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-6 rounded shadow-sm">
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

<!-- Mobile sidebar (hidden by default) -->
<div id="mobileSidebar" class="fixed inset-0 z-20 hidden">
    <div class="absolute inset-0 bg-gray-600 opacity-75" id="sidebarOverlay"></div>
    <div class="relative w-64 bg-indigo-800 h-full shadow-xl sidebar-transition">
        <div class="p-5 border-b border-indigo-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-ticket-alt text-2xl text-white"></i>
                    <span class="text-xl font-bold text-white">Admin Panel</span>
                </div>
                <button id="closeSidebar" class="text-white">&times;</button>
            </div>
        </div>
        <nav class="mt-5 px-2">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded text-white hover:bg-indigo-700">Dashboard</a>
            <a href="{{ route('admin.venues.index') }}" class="block py-2.5 px-4 rounded text-white hover:bg-indigo-700">Venue</a>
            <a href="{{ route('admin.konsers.index') }}" class="block py-2.5 px-4 rounded text-white hover:bg-indigo-700">Konser</a>
            <a href="{{ route('admin.laporan.tiket') }}" class="block py-2.5 px-4 rounded text-white hover:bg-indigo-700">Laporan Tiket</a>
        </nav>
    </div>
</div>

<script>
    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mobileSidebar = document.getElementById('mobileSidebar');
    const closeSidebar = document.getElementById('closeSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if(sidebarToggle) {
        sidebarToggle.addEventListener('click', () => {
            mobileSidebar.classList.remove('hidden');
        });
    }
    const closeSidebarFunc = () => mobileSidebar.classList.add('hidden');
    if(closeSidebar) closeSidebar.addEventListener('click', closeSidebarFunc);
    if(overlay) overlay.addEventListener('click', closeSidebarFunc);
</script>
</body>
</html>