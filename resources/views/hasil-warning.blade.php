@extends('layouts.app')

@section('title', 'Perlu Perhatian - Olive Verify')

@section('content')
@php($data = session('data_verifikasi', []))
<section class="bg-paper">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-20">

        <div class="bg-white rounded-2xl shadow-soft border border-primary/10 overflow-hidden">

            <div class="bg-warning/5 border-b border-warning/10 px-8 py-10 text-center">
                <svg viewBox="0 0 200 200" class="w-24 h-24 mx-auto mb-5 -rotate-6" aria-hidden="true">
                    <defs>
                        <path id="sealWarning" d="M 100,100 m -78,0 a 78,78 0 1,1 156,0 a 78,78 0 1,1 -156,0" />
                    </defs>
                    <circle cx="100" cy="100" r="92" fill="none" stroke="#F59E0B" stroke-width="2.5"/>
                    <circle cx="100" cy="100" r="78" fill="none" stroke="#F59E0B" stroke-width="1.5"/>
                    <text font-family="Poppins, sans-serif" font-size="10.5" font-weight="600" letter-spacing="2.5" fill="#F59E0B">
                        <textPath href="#sealWarning" startOffset="1%">OLIVE VERIFY ✦ PERLU PERHATIAN ✦</textPath>
                    </text>
                    <g transform="translate(100,100)">
                        <circle r="34" fill="#F59E0B"/>
                        <path d="M0 -16 L0 6" stroke="white" stroke-width="4.5" stroke-linecap="round"/>
                        <circle cx="0" cy="16" r="2.6" fill="white"/>
                    </g>
                </svg>
                <h1 class="font-display font-semibold text-2xl text-ink mb-2">Perlu Perhatian</h1>
                <p class="text-sm text-subtext max-w-sm mx-auto">QR Code ini telah diverifikasi beberapa kali. Pastikan produk diperoleh dari penjual resmi.</p>
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

                <div class="mt-6 p-4 rounded-xl bg-warning/5 border border-warning/20 text-sm text-ink">
                    Jika Anda merasa membeli produk ini dari sumber yang tidak resmi, segera laporkan melalui halaman Bantuan.
                </div>
            </div>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('verifikasi') }}" class="text-sm font-medium text-primary hover:underline">Verifikasi produk lain</a>
        </div>
    </div>
</section>
@endsection