@extends('layouts.app')

@section('title', 'Kode Tidak Valid - Olive Verify')

@section('content')
<section class="bg-paper">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">

        <div class="bg-white rounded-2xl shadow-soft border border-primary/10 overflow-hidden">
            <div class="bg-danger/5 border-b border-danger/10 px-8 py-12 text-center">
                <div class="w-20 h-20 mx-auto mb-5 rounded-full border-2 border-dashed border-danger/40 flex items-center justify-center">
                    <svg class="w-9 h-9 text-danger" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>

                @if (session('alasan') === 'pemalsuan')
                    <h1 class="font-display font-semibold text-2xl text-ink mb-2">Indikasi Pemalsuan Terdeteksi</h1>
                    <p class="text-sm text-subtext max-w-sm mx-auto">Produk ini sudah discan melebihi batas wajar. Kemungkinan QR Code telah digandakan atau disalahgunakan. Jangan gunakan produk ini, laporkan ke pihak berwenang.</p>
                @else
                    <h1 class="font-display font-semibold text-2xl text-ink mb-2">Produk Tidak Terverifikasi</h1>
                    <p class="text-sm text-subtext max-w-sm mx-auto">Kode yang Anda masukkan tidak ditemukan dalam sistem. Pastikan QR Code berasal dari kemasan resmi.</p>
                @endif
            </div>

            <div class="p-8 text-center">
                <a href="{{ route('verifikasi') }}" class="inline-flex px-6 py-3 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition">
                    Coba Verifikasi Lagi
                </a>
            </div>
        </div>
    </div>
</section>
@endsection