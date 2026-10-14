@extends('layouts.admin')

@section('title', 'Dashboard - Olive Verify')

@section('content')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-8">
        <div>
            <h1 class="font-display font-semibold text-2xl text-ink">Dashboard</h1>
            <p class="text-sm text-subtext mt-1">Selamat datang kembali, {{ auth()->user()->name ?? 'Admin' }}!</p>
        </div>
        <span class="text-sm text-subtext bg-white border border-gray-100 rounded-xl px-4 py-2">
            {{ now()->translatedFormat('l, d F Y') }}
        </span>
    </div>

        {{-- ============ SUMMARY CARDS ============ --}}
    <div class="grid sm:grid-cols-3 gap-5 mb-8">
        @php
            $summary = [
                ['label' => 'Total Produk', 'value' => number_format($totalProduk, 0, ',', '.'), 'sub' => 'Produk terdaftar'],
                ['label' => 'Total Batch', 'value' => number_format($totalBatch, 0, ',', '.'), 'sub' => 'Batch produksi'],
                ['label' => 'Total QR Code', 'value' => number_format($totalQrCode, 0, ',', '.'), 'sub' => 'QR Code dibuat'],
            ];
        @endphp
        @foreach ($summary as $s)
            <div class="bg-white rounded-2xl border border-gray-50 shadow-soft p-6">
                <p class="text-sm text-subtext mb-1">{{ $s['label'] }}</p>
                <p class="font-display font-semibold text-3xl text-ink">{{ $s['value'] }}</p>
                <p class="text-xs text-subtext mt-1">{{ $s['sub'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- ============ SHORTCUT ============ --}}
    <div class="mb-8">
        <h2 class="font-semibold text-ink mb-3">Shortcut</h2>
        <div class="grid sm:grid-cols-3 gap-4">
            <a href="{{ route('admin.produk.index') }}" class="flex items-center gap-3 bg-white rounded-xl border border-gray-100 p-4 hover:border-primary/30 hover:shadow-soft transition">
                <span class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M20 7L12 3 4 7m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </span>
                <span class="text-sm font-medium text-ink">Kelola Produk</span>
            </a>
            <a href="{{ route('admin.batch.index') }}" class="flex items-center gap-3 bg-white rounded-xl border border-gray-100 p-4 hover:border-primary/30 hover:shadow-soft transition">
                <span class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h6v6h-6v-6z"/></svg>
                </span>
                <span class="text-sm font-medium text-ink">Batch Produksi</span>
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="flex items-center gap-3 bg-white rounded-xl border border-gray-100 p-4 hover:border-primary/30 hover:shadow-soft transition">
                <span class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 17v-6m4 6V7m4 10v-3M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                </span>
                <span class="text-sm font-medium text-ink">Laporan</span>
            </a>
        </div>
    </div>

    {{-- ============ BATCH TERBARU ============ --}}
    <div class="bg-white rounded-2xl border border-gray-50 shadow-soft overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-ink">Batch Terbaru</h2>
            <a href="{{ route('admin.batch.index') }}" class="text-sm font-medium text-primary hover:underline">Lihat Semua Batch</a>
        </div>
        <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-subtext border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">Kode Batch</th>
                        <th class="px-6 py-3 font-medium">Produk</th>
                        <th class="px-6 py-3 font-medium">Jumlah QR</th>
                        <th class="px-6 py-3 font-medium">Tanggal Produksi</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                                <tbody>
                    @forelse ($batchTerbaru as $batch)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="px-6 py-3.5 font-medium text-ink">{{ $batch->batch_code }}</td>
                            <td class="px-6 py-3.5 text-ink">{{ $batch->product->name }}</td>
                            <td class="px-6 py-3.5 text-ink">{{ $batch->qr_count }}</td>
                            <td class="px-6 py-3.5 text-subtext">{{ $batch->production_date->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="{{ route('admin.batch.show', $batch->id) }}" class="text-primary font-medium hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-subtext">Belum ada batch produksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

                <div class="md:hidden divide-y divide-gray-50">
            @forelse ($batchTerbaru as $batch)
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-medium text-ink text-sm">{{ $batch->batch_code }}</p>
                            <p class="text-xs text-subtext mt-0.5">{{ $batch->product->name }}</p>
                        </div>
                        <span class="text-xs text-subtext whitespace-nowrap">{{ $batch->qr_count }} QR</span>
                    </div>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-50">
                        <span class="text-xs text-subtext">{{ $batch->production_date->translatedFormat('d M Y') }}</span>
                        <a href="{{ route('admin.batch.show', $batch->id) }}" class="text-primary text-sm font-medium hover:underline">Detail</a>
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-subtext text-sm">Belum ada batch produksi.</div>
            @endforelse
        </div>
    </div>

@endsection
