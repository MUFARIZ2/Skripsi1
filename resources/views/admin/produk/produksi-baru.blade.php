@extends('layouts.admin')

@section('title', 'Produksi Baru - Olive Verify')

@section('content')

    <div class="flex items-center gap-2 text-sm text-subtext mb-6 flex-wrap">
        <a href="{{ route('admin.produk.index') }}" class="hover:text-primary">Kelola Produk</a>
        <span>/</span>
        <a href="{{ route('admin.produk.show', $product->id) }}" class="hover:text-primary">Detail Produk</a>
        <span>/</span>
        <span class="text-ink font-medium">Produksi Baru</span>
    </div>

    <div class="max-w-2xl mx-auto">

        <h1 class="font-display font-semibold text-2xl text-ink mb-6">Produksi Baru</h1>

        {{-- produk terpilih --}}
        <div class="bg-white rounded-2xl border border-gray-50 shadow-soft p-5 flex items-center gap-4 mb-6">
            <div class="w-16 h-16 rounded-xl bg-bg border border-gray-100 flex items-center justify-center shrink-0 overflow-hidden">
                @if ($product->image)
                    <img src="{{ asset( $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-8 h-8 text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3h6l1 4H8l1-4zM8 7h8l1 12a2 2 0 01-2 2H9a2 2 0 01-2-2L8 7z"/></svg>
                @endif
            </div>
            <div>
                <span class="inline-block px-2 py-0.5 rounded-full bg-mint/20 text-primary-dark text-xs font-semibold mb-1">{{ $product->category }}</span>
                <h2 class="font-semibold text-ink">{{ $product->name }}</h2>
                <p class="text-sm text-subtext">{{ $product->ukuran ?? '-' }}</p>
            </div>
        </div>

        {{-- form batch --}}
        <form action="{{ route('admin.produk.produksi-baru.store', $product->id) }}" method="POST" class="bg-white rounded-2xl border border-gray-50 shadow-soft p-8 space-y-5">
            @csrf

            <div>
                <label for="kode_batch" class="block text-sm font-medium text-ink mb-2">Kode Batch</label>
                <input type="text" id="kode_batch" value="{{ $previewBatchCode }}" readonly
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-bg text-sm text-ink">
                <p class="text-xs text-subtext mt-1.5">Otomatis dibuat oleh sistem saat disimpan.</p>
            </div>

            <div>
                <label for="jumlah" class="block text-sm font-medium text-ink mb-2">Jumlah Produksi / Jumlah QR</label>
                <input type="number" id="jumlah" name="jumlah" min="1" max="5000" value="{{ old('jumlah') }}" placeholder="Contoh: 500" required
                       class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                <p class="text-xs text-subtext mt-1.5">Minimal 1, maksimal 5000 QR sekali produksi.</p>
                @error('jumlah')
                    <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="tgl_produksi" class="block text-sm font-medium text-ink mb-2">Tanggal Produksi</label>
                    <input type="date" id="tgl_produksi" name="tgl_produksi" value="{{ old('tgl_produksi', now()->format('Y-m-d')) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    @error('tgl_produksi')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tgl_expired" class="block text-sm font-medium text-ink mb-2">Tanggal Expired</label>
                    <input type="date" id="tgl_expired" name="tgl_expired" value="{{ old('tgl_expired') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    @error('tgl_expired')
                        <p class="text-xs text-red-600 mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="p-4 rounded-xl bg-primary/5 border border-primary/10 text-sm text-ink">
                Sistem akan membuat <strong>1 batch produksi</strong> beserta <strong>QR Code unik</strong> sejumlah kuantitas di atas, masing-masing dengan serial berbeda berbasis kode batch.
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.produk.show', $product->id) }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-ink hover:bg-bg transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft">Generate Batch &amp; QR</button>
            </div>
        </form>
    </div>

@endsection