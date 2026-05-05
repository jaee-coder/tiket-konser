@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
    <div class="text-center mb-8">
        <div class="mx-auto w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
            <i class="fas fa-ticket-alt text-3xl text-indigo-600"></i>
        </div>
        <h2 class="mt-4 text-2xl font-bold text-gray-800">Selamat Datang</h2>
        <p class="text-gray-500 text-sm mt-1">Masuk ke akun Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg transition duration-200">
            Masuk
        </button>

        <p class="text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:underline">Daftar sekarang</a>
        </p>
    </form>
</div>
@endsection