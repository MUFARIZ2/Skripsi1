@extends('layouts.app')

@section('title', 'Produk Terverifikasi - Olive Verify')

@section('content')
@php($data = session('data_verifikasi', []))
<section class="bg-paper">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">

        <div class="bg-white rounded-2xl shadow-soft border border-primary/10 overflow-hidden">

            <div class="bg-success/5 border-b border-success/10 px-8 py-10 text-center">
                <svg viewBox="0 0 200 200" class="w-24 h-24 mx-auto mb-5" aria-hidden="true">
                    <defs>
                        <path id="sealAsli" d="M 100,100 m -78,0 a 78,78 0 1,1 156,0 a 78,78 0 1,1 -156,0" />
                    </defs>
                    <circle cx="100" cy="100" r="92" fill="none" stroke="#16A34A" stroke-width="2.5"/>
                    <circle cx="100" cy="100" r="78" fill="none" stroke="#16A34A" stroke-width="1.5"/>
                    <text font-family="Poppins, sans-serif" font-size="10.5" font-weight="600" letter-spacing="2.5" fill="#16A34A">
                        <textPath href="#sealAsli" startOffset="1%">OLIVE VERIFY ✦ TERVERIFIKASI ✦</textPath>
                    </text>
                    <g transform="translate(100,100)">
                        <circle r="34" fill="#16A34A"/>
                        <path d="M-14 1 L-4 11 L16 -11" fill="none" stroke="white" stroke-width="4.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
                <h1 class="font-display font-semibold text-2xl text-ink mb-2">Produk Terverifikasi</h1>
                <p class="text-sm text-subtext">Produk ini terdaftar sebagai produk asli.</p>
            </div>

            <div class="p-8">
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                    <div class="w-16 h-16 rounded-xl bg-paper border border-primary/10 flex items-center justify-center shrink-0">
                        <svg class="w-8 h-8 text-primary/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3h6l1 4H8l1-4zM8 7h8l1 12a2 2 0 01-2 2H9a2 2 0 01-2-2L8 7z"/></svg>
                    </div>
                    <div>
                        <h2 class="font-semibold text-ink">{{ $data['nama_produk'] ?? '-' }}</h2>
                        <p class="text-sm text-subtext">Varian {{ $data['varian'] ?? '-' }} &middot; {{ $data['ukuran'] ?? '-' }}</p>
                    </div>
                </div>

                <dl class="grid grid-cols-2 gap-y-4 text-sm">
                    @foreach ([
                        'Kode Batch' => $data['kode_batch'] ?? '-',
                        'Serial QR' => $data['serial_qr'] ?? '-',
                        'Tanggal Produksi' => $data['tanggal_produksi'] ?? '-',
                        'Tanggal Kedaluwarsa' => $data['tanggal_kedaluwarsa'] ?? '-',
                    ] as $label => $value)
                        <div>
                            <dt class="text-subtext mb-0.5">{{ $label }}</dt>
                            <dd class="font-medium text-ink">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>

                @if (!empty($data['komposisi']))
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <p class="text-sm text-subtext mb-1">Komposisi</p>
                        <p class="text-sm font-medium text-ink">{{ $data['komposisi'] }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('verifikasi') }}" class="text-sm font-medium text-primary hover:underline">Verifikasi produk lain</a>
        </div>
    </div>
</section>
@endsection