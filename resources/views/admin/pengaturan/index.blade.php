@extends('layouts.admin')

@section('title', 'Pengaturan - Tradisi Verify')

@section('content')

    <div class="mb-6">
        <h1 class="font-display font-semibold text-2xl text-ink">Pengaturan</h1>
        <p class="text-sm text-subtext mt-1">Kelola profil dan akun Anda.</p>
    </div>

    <div class="max-w-lg bg-white rounded-2xl border border-gray-50 shadow-soft p-8">
        <h2 class="font-semibold text-ink mb-5">Profil Admin</h2>

        <form action="{{ route('admin.pengaturan.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-4 mb-2">
                <span class="w-16 h-16 rounded-full bg-mint/30 text-primary-dark font-display font-semibold text-xl flex items-center justify-center">
                    {{ strtoupper(substr(auth()->user()->name ?? 'Admin', 0, 1)) }}
                </span>
                <button type="button" class="px-4 py-2 rounded-lg border border-gray-200 text-sm font-medium text-ink hover:bg-bg transition">Ganti Foto</button>
            </div>

            <div>
                <label for="nama" class="block text-sm font-medium text-ink mb-2">Nama</label>
                <input type="text" id="nama" name="nama" value="{{ auth()->user()->name ?? 'Admin' }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-ink mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ auth()->user()->email ?? 'admin@tradisiverify.id' }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft">Simpan</button>
            </div>
        </form>
    </div>

@endsection
