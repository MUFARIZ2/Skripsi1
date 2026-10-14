@extends('layouts.auth')

@section('title', 'Login Admin - Olive Verify')

@section('content')
<style>
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
        -webkit-text-fill-color: #1F2937;
        -webkit-box-shadow: 0 0 0 1000px #ffffff inset;
        box-shadow: 0 0 0 1000px #ffffff inset;
        transition: background-color 9999s ease-in-out 0s;
    }
</style>
    <h1 class="font-display font-semibold text-2xl text-ink mb-1">Login Admin</h1>
    <p class="text-sm text-subtext mb-8">Masuk untuk mengelola produk dan verifikasi.</p>

    @if ($errors->any())
        <div class="mb-5 px-4 py-3 rounded-xl bg-danger/5 border border-danger/20 text-sm text-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-ink mb-2">Email</label>
            <div class="relative">
                <svg class="w-4 h-4 text-subtext absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <input type="email" id="email" name="email" required autofocus placeholder="admin@gmail.com"
                       class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-ink mb-2">Password</label>
            <div class="relative">
                <svg class="w-4 h-4 text-subtext absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <input type="password" id="password" name="password" required placeholder="Masukkan password"
                       class="w-full pl-10 pr-11 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                <button type="button" id="togglePassword" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-subtext hover:text-ink">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </button>
            </div>
        </div>

        <div class="flex items-center text-sm">
            {{-- <label class="flex items-center gap-2 text-subtext">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary/30">
                Ingat saya
            </label> --}}
            {{-- Link "Lupa password?" dinonaktifkan sementara — fitur ditiadakan, tapi kode disimpan buat jaga-jaga
            <a href="{{ route('admin.password.request') }}" class="text-primary font-medium hover:underline">Lupa password?</a>
            --}}
        </div>

        <button type="submit" class="w-full py-3 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft inline-flex items-center justify-center gap-2">
            Login
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
        </button>
    </form>

    {{-- Link "Daftar" dinonaktifkan sementara — fitur register ditiadakan, tapi kode disimpan buat jaga-jaga
    <p class="text-center text-sm text-subtext mt-8">
        Belum memiliki akun?
        <a href="{{ route('admin.register') }}" class="text-primary font-semibold hover:underline">Daftar</a>
    </p>
    --}}

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    </script>
@endsection