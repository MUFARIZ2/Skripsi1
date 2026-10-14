@extends('layouts.auth')

@section('title', 'Daftar Admin - Olive Verify')

@section('content')
    <h1 class="font-display font-semibold text-2xl text-ink mb-1">Daftar Admin</h1>
    <p class="text-sm text-subtext mb-8">Buat akun untuk mulai mengelola produk.</p>

    @if ($errors->any())
        <div class="mb-5 px-4 py-3 rounded-xl bg-danger/5 border border-danger/20 text-sm text-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.register.submit') }}" class="space-y-5">
        @csrf
        <div>
            <label for="name" class="block text-sm font-medium text-ink mb-2">Nama Lengkap</label>
            <input type="text" id="name" name="name" required autofocus
                   class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
        </div>
        <div>
            <label for="email" class="block text-sm font-medium text-ink mb-2">Email</label>
            <input type="email" id="email" name="email" required
                   class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-ink mb-2">Password</label>
            <input type="password" id="password" name="password" required
                   class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
        </div>
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-ink mb-2">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required
                   class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
        </div>

        <button type="submit" class="w-full py-3 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft">
            Daftar
        </button>
    </form>

    <p class="text-center text-sm text-subtext mt-8">
        Sudah memiliki akun?
        <a href="{{ route('admin.login') }}" class="text-primary font-semibold hover:underline">Login</a>
    </p>
@endsection
