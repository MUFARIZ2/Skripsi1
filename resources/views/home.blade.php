@extends('layouts.app')

@section('title', 'Olive Verify - Verifikasi Keaslian Produk')

@section('content')

    
{{-- ============ HERO ============ --}}
<section class="bg-paper overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-24 grid lg:grid-cols-[1.1fr_0.9fr] gap-10 items-center">
        <div class="max-w-lg">
            <h1 class="font-display font-semibold text-3xl sm:text-4xl lg:text-5xl leading-[1.15] text-primary mb-5">
                Pastikan Keaslian Minuman Tradisional Anda
            </h1>
            <p class="text-ink/70 text-base lg:text-lg leading-relaxed mb-8 max-w-md">
                Setiap kemasan resmi Olive Verify punya QR Code unik. Scan untuk memastikan produk jamu atau minuman herbal Anda asli.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('verifikasi') }}" class="w-full sm:w-auto text-center px-6 py-3 rounded-xl bg-primary text-white font-semibold text-sm hover:bg-primary-dark transition shadow-soft">
                    Verifikasi Produk
                </a>
                <a href="#cara-verifikasi" class="w-full sm:w-auto text-center px-6 py-3 rounded-xl border border-primary/25 text-primary font-semibold text-sm hover:bg-primary/5 transition">
                    Cara Verifikasi
                </a>
            </div>
        </div>

                {{-- <div class="flex justify-center lg:justify-end">
            <img src="{{ asset('cap_teh_olive.png') }}" alt="Cap Teh Olive"
                 class="w-48 h-48 sm:w-60 sm:h-60 lg:w-72 lg:h-72 object-contain -rotate-6 drop-shadow-md">
        </div> --}}
    </div>
</section>

    {{-- ============ CARA VERIFIKASI ============ --}}
<section id="cara-verifikasi" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
    <div class="text-center max-w-xl mx-auto mb-12">
        <h2 class="font-display font-semibold text-2xl lg:text-3xl text-ink mb-3">Bagaimana Cara Verifikasi?</h2>
        <p class="text-subtext">Empat langkah sederhana untuk memastikan produk Anda asli.</p>
    </div>

    @php
        $steps = [
            ['n' => '01', 't' => 'Temukan QR Code', 'd' => 'Cari QR Code yang tertera pada kemasan produk.'],
            ['n' => '02', 't' => 'Scan QR Code', 'd' => 'Pindai QR Code menggunakan kamera ponsel Anda.'],
            ['n' => '03', 't' => 'Sistem Verifikasi', 'd' => 'Sistem memeriksa keaslian kode secara otomatis.'],
            ['n' => '04', 't' => 'Lihat Hasil', 'd' => 'Hasil keaslian produk ditampilkan secara langsung.'],
        ];
    @endphp

    {{-- Mobile & tablet: daftar vertikal dengan pembatas titik-titik --}}
    <div class="lg:hidden divide-y divide-dashed divide-primary/20 border-t border-b border-dashed border-primary/20">
        @foreach ($steps as $s)
            <div class="flex items-start gap-4 py-5">
                <span class="shrink-0 w-10 h-10 rounded-full border-2 border-primary flex items-center justify-center font-display font-semibold text-primary text-sm">
                    {{ $s['n'] }}
                </span>
                <div>
                    <h3 class="font-semibold text-ink mb-1">{{ $s['t'] }}</h3>
                    <p class="text-sm text-subtext leading-relaxed">{{ $s['d'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Desktop: alur horizontal tersambung garis, mencerminkan urutan langkah --}}
    <div class="hidden lg:flex items-start">
        @foreach ($steps as $s)
            <div class="flex-1 relative px-4 text-center">
                @if (!$loop->last)
                    <div class="absolute top-6 left-1/2 w-full h-px border-t border-dashed border-primary/25"></div>
                @endif
                <span class="relative z-10 inline-flex w-12 h-12 rounded-full border-2 border-primary bg-white items-center justify-center font-display font-semibold text-primary mb-4">
                    {{ $s['n'] }}
                </span>
                <h3 class="font-semibold text-ink mb-1.5">{{ $s['t'] }}</h3>
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

        {{-- Panel bahan baku jamu — nyambung langsung ke teks di sebelah kiri --}}
        {{-- <div class="bg-paper rounded-2xl p-8 sm:p-10 border border-primary/10">
            <p class="text-xs font-semibold tracking-wide text-primary/70 mb-6">Bahan baku yang dijamin keasliannya</p>
            <div class="grid grid-cols-3 gap-4 sm:gap-6">
                @php
                    $bahan = [
                        ['label' => 'Kunyit', 'accent' => true],
                        ['label' => 'Jahe', 'accent' => false],
                        ['label' => 'Asam Jawa', 'accent' => false],
                    ];
                @endphp
                @foreach ($bahan as $b)
                    <div class="flex flex-col items-center text-center gap-2">
                        <span class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-white flex items-center justify-center border border-primary/10">
                            @if ($b['label'] === 'Kunyit')
                                <svg viewBox="0 0 48 48" class="w-7 h-7 text-turmeric" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" stroke-linecap="round">
                                    <path d="M24 6C14 10 8 20 10 30c1 6 6 10 12 10s11-4 12-10c2-10-4-20-10-24z"/>
                                </svg>
                            @elseif ($b['label'] === 'Jahe')
                                <svg viewBox="0 0 48 48" class="w-7 h-7 text-primary" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" stroke-linecap="round">
                                    <path d="M10 34c-2-6 0-14 6-18 5-3 11-2 14 2 2 3 2 7-1 9 3 1 5 4 4 7-2 5-9 6-13 4-4-2-8-2-10-4z"/>
                                </svg>
                            @else
                                <svg viewBox="0 0 48 48" class="w-7 h-7 text-primary" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" stroke-linecap="round">
                                    <path d="M8 24c0-6 5-11 12-11s12 5 12 11-5 14-12 14S8 30 8 24z"/>
                                    <circle cx="20" cy="22" r="1.4" fill="currentColor" stroke="none"/>
                                    <circle cx="26" cy="26" r="1.4" fill="currentColor" stroke="none"/>
                                </svg>
                            @endif
                        </span>
                        <span class="text-xs font-medium text-ink">{{ $b['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div> --}}
    </div>
</section>

    {{-- ============ BANTUAN ============ --}}
<section id="bantuan" class="bg-paper">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20 text-center">
        <h2 class="font-display font-semibold text-2xl lg:text-3xl text-ink mb-3">Butuh Bantuan?</h2>
        <p class="text-ink/70 max-w-md mx-auto mb-6">Jika QR Code tidak dapat dipindai atau Anda menemukan kejanggalan pada produk, segera hubungi kami.</p>
        {{-- <a href="mailto:bantuan@tradisiverify.id" class="inline-flex px-6 py-3 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft"> --}}
            <a href="https://wa.me/6281219162525?text=Halo%20Olive%20Verify%2C%20saya%20butuh%20bantuan." target="_blank" rel="noopener" class="inline-flex px-6 py-3 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft">
            Hubungi Kami
        </a>
    </div>
</section>

@endsection
