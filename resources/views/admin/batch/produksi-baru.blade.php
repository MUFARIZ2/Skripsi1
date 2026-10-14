@extends('layouts.admin')

@section('title', 'Tambah Batch Produksi - Olive Verify')

@section('content')

    <div class="flex items-center gap-2 text-sm text-subtext mb-6 flex-wrap">
        <a href="{{ route('admin.batch.index') }}" class="hover:text-primary">Batch Produksi</a>
        <span>/</span>
        <span class="text-ink font-medium">Tambah Batch Produksi</span>
    </div>

    <div class="max-w-2xl mx-auto">

        <h1 class="font-display font-semibold text-2xl text-ink mb-6">Tambah Batch Produksi</h1>

        <form action="{{ route('admin.batch.produksi-baru.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="bg-white rounded-2xl border border-gray-50 shadow-soft divide-y divide-gray-50">
                @foreach ($products as $product)
                    <div class="p-5 flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-bg border border-gray-100 flex items-center justify-center shrink-0 overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-7 h-7 text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3h6l1 4H8l1-4zM8 7h8l1 12a2 2 0 01-2 2H9a2 2 0 01-2-2L8 7z"/></svg>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-ink text-sm truncate">{{ $product->name }}</p>
                            <p class="text-xs text-subtext">{{ $product->category }}</p>
                        </div>

                        <div class="w-32 shrink-0">
                            <input type="hidden" name="produk_ids[]" value="{{ $product->id }}">
                            <input type="number" name="qty[{{ $product->id }}]" min="1" max="5000"
                                   value="{{ old('qty.' . $product->id) }}" placeholder="Jumlah QR" required
                                   class="qty-input w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-right focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            @error('qty.' . $product->id)
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="bg-white rounded-2xl border border-gray-50 shadow-soft p-6 grid sm:grid-cols-2 gap-5">
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

            <div class="p-4 rounded-xl bg-primary/5 border border-primary/10 text-sm text-ink flex items-center justify-between">
                <span>Total QR yang akan dibuat</span>
                <span id="totalQr" class="font-semibold text-lg">0</span>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.batch.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-ink hover:bg-bg transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft">Generate QR</button>
            </div>
        </form>
    </div>

    <script>
        function hitungTotalQr() {
            let total = 0;
            document.querySelectorAll('.qty-input').forEach(function (input) {
                const val = parseInt(input.value, 10);
                if (!isNaN(val)) total += val;
            });
            document.getElementById('totalQr').textContent = total;
        }

        document.querySelectorAll('.qty-input').forEach(function (input) {
            input.addEventListener('input', hitungTotalQr);
        });

        hitungTotalQr();
    </script>

@endsection