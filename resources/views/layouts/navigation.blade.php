<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">TiketKonser</a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out">Home</a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out">Dashboard</a>
                    @endauth
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <div class="relative">
                    <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700">
                        {{ Auth::user()->name }}
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="ml-3 text-sm text-gray-500 hover:text-gray-700">Logout</button>
                    </form>
                </div>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700">Login</a>
                    <a href="{{ route('register') }}" class="ml-3 text-sm text-gray-700">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>