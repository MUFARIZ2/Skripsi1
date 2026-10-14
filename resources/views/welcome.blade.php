@extends('layouts.app')

@section('title', 'Olive Verify - Verifikasi Keaslian Produk')

@section('content')

    {{-- ============ HERO ============ --}}
    <section class="relative overflow-hidden bg-primary">
        <svg class="absolute -right-16 -top-16 w-96 h-96 opacity-10" viewBox="0 0 200 200" fill="none">
            <circle cx="100" cy="100" r="96" stroke="white" stroke-width="2" stroke-dasharray="4 6"/>
            <circle cx="100" cy="100" r="72" stroke="white" stroke-width="2"/>
        </svg>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 grid lg:grid-cols-2 gap-12 items-center relative z-10">
            <div>
                <span class="inline-block px-3 py-1 rounded-full bg-white/10 text-mint text-xs font-semibold tracking-wide mb-5">MINUMAN TRADISIONAL BERSERTIFIKAT</span>
                <h1 class="font-display font-semibold text-3xl sm:text-4xl lg:text-[2.75rem] leading-tight text-white mb-4">
                    Pastikan Keaslian Minuman Tradisional Anda
                </h1>
                <p class="text-white/70 text-base lg:text-lg mb-8 max-w-md">
                    Scan QR Code pada kemasan untuk mengetahui keaslian dan informasi produk jamu &amp; minuman herbal Anda.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('verifikasi') }}" class="px-6 py-3 rounded-xl bg-white text-primary font-semibold text-sm hover:bg-mint/20 transition shadow-soft">
                        Verifikasi Produk
                    </a>
                    <a href="#cara-verifikasi" class="px-6 py-3 rounded-xl border border-white/30 text-white font-semibold text-sm hover:bg-white/10 transition">
                        Cara Verifikasi
                    </a>
                </div>
            </div>

            <div class="relative">
                <div class="bg-white/5 rounded-2xl p-8 flex items-center justify-center">
                    {{-- Ilustrasi produk jamu (ganti dengan foto produk asli) --}}
                    <div class="w-56 h-72 bg-gradient-to-b from-mint/30 to-white/10 rounded-2xl border border-white/20 flex flex-col items-center justify-center gap-3">
                        <svg class="w-16 h-16 text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3h6l1 4H8l1-4zM8 7h8l1 12a2 2 0 01-2 2H9a2 2 0 01-2-2L8 7z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6"/>
                        </svg>
                        <span class="text-white/70 text-sm font-medium">Jamu Kunyit Asam</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ CARA VERIFIKASI ============ --}}
    <section id="cara-verifikasi" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="font-display font-semibold text-2xl lg:text-3xl text-ink mb-3">Bagaimana Cara Verifikasi?</h2>
            <p class="text-subtext">Empat langkah sederhana untuk memastikan produk Anda asli.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $steps = [
                    ['n' => '01', 't' => 'Temukan QR Code', 'd' => 'Cari QR Code yang tertera pada kemasan produk.'],
                    ['n' => '02', 't' => 'Scan QR Code', 'd' => 'Pindai QR Code menggunakan kamera ponsel Anda.'],
                    ['n' => '03', 't' => 'Sistem Verifikasi', 'd' => 'Sistem memeriksa keaslian kode secara otomatis.'],
                    ['n' => '04', 't' => 'Lihat Hasil', 'd' => 'Hasil keaslian produk ditampilkan secara langsung.'],
                ];
            @endphp
            @foreach ($steps as $s)
                <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-50">
                    <span class="font-display text-2xl font-semibold text-mint">{{ $s['n'] }}</span>
                    <h3 class="font-semibold text-ink mt-3 mb-1.5">{{ $s['t'] }}</h3>
                    <p class="text-sm text-subtext leading-relaxed">{{ $s['d'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ============ TENTANG PRODUK / PENTINGNYA PRODUK ASLI ============ --}}
    <section id="tentang-produk" class="bg-white border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="font-display font-semibold text-2xl lg:text-3xl text-ink mb-4">Kenapa Membeli Produk Asli Itu Penting?</h2>
                <p class="text-subtext leading-relaxed mb-6">
                    Minuman tradisional seperti jamu dan minuman herbal diracik dengan resep dan takaran khusus.
                    Produk tiruan berisiko menggunakan bahan yang tidak terjamin kualitas dan keamanannya.
                    Dengan Olive Verify, setiap kemasan resmi memiliki QR Code unik yang dapat diverifikasi langsung.
                </p>
                <ul class="space-y-3">
                    @foreach ([
                        'Menjamin keamanan dan kualitas bahan baku',
                        'Mendukung produsen minuman tradisional lokal',
                        'Melindungi Anda dari produk palsu/tiruan',
                    ] as $point)
                        <li class="flex items-start gap-3 text-sm text-ink">
                            <span class="mt-0.5 w-5 h-5 rounded-full bg-success/10 text-success flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            {{ $point }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="bg-bg rounded-2xl p-10 flex items-center justify-center border border-gray-100">
                <div class="w-40 h-40 rounded-full border-4 border-dashed border-mint/50 flex items-center justify-center">
                    <span class="font-display font-semibold text-primary text-sm text-center leading-snug">100%<br>Terverifikasi</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ BANTUAN ============ --}}
    <section id="bantuan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20 text-center">
        <h2 class="font-display font-semibold text-2xl text-ink mb-3">Butuh Bantuan?</h2>
        <p class="text-subtext max-w-md mx-auto mb-6">Jika QR Code tidak dapat dipindai atau Anda menemukan kejanggalan pada produk, segera hubungi kami.</p>
        <a href="mailto:bantuan@tradisiverify.id" class="inline-flex px-6 py-3 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition">
            Hubungi Kami
        </a>
    </section>

@endsection
