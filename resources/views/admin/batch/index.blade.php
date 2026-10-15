@extends('layouts.admin')

@section('title', 'Batch Produksi - Olive Verify')

@section('content')
    @if (session('success'))
        <div id="alert-success" class="flex items-center gap-3 px-5 py-4 mb-6 rounded-xl bg-green-50 border border-green-200 text-green-800 text-sm font-medium transition-opacity duration-500">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function () {
                const alertEl = document.getElementById('alert-success');
                if (alertEl) {
                    alertEl.style.opacity = '0';
                    setTimeout(() => alertEl.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    @if (session('error'))
        <div id="alert-error" class="flex items-start gap-3 px-5 py-4 mb-6 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-medium transition-opacity duration-500">            <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        <span>{{ session('error') }}</span>
        </div>

        <script>
            setTimeout(function () {
                const alertEl = document.getElementById('alert-error');
                if (alertEl) {
                    alertEl.style.opacity = '0';
                    setTimeout(() => alertEl.remove(), 500);
                }
            }, 5000);
        </script>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-display font-semibold text-2xl text-ink">Batch Produksi</h1>
            <p class="text-sm text-subtext mt-1">Daftar seluruh batch produksi yang telah dibuat.</p>
        </div>
        <button type="button" onclick="document.getElementById('modalPilihProduk').classList.remove('hidden')" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Batch Baru
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-50 shadow-soft overflow-hidden">

<form method="GET" action="{{ route('admin.batch.index') }}" class="flex flex-col sm:flex-row gap-3 px-6 py-4 border-b border-gray-100">
    <div class="relative flex-1">
        <svg class="w-4 h-4 text-subtext absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="cari" id="cariInput" value="{{ request('cari') }}" placeholder="Cari kode batch..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
    </div>
    <select name="produk" onchange="this.form.submit()" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-primary/30">
        <option value="semua" {{ request('produk', 'semua') === 'semua' ? 'selected' : '' }}>Semua Produk</option>
        @foreach ($productList as $p)
            <option value="{{ $p->id }}" {{ (string) request('produk') === (string) $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        Cari
    </button>
</form>

        <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-subtext border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">No</th>
                        <th class="px-6 py-3 font-medium">Kode Batch</th>
                        <th class="px-6 py-3 font-medium">Produk</th>
                        <th class="px-6 py-3 font-medium">Jumlah QR</th>
                        <th class="px-6 py-3 font-medium">Tanggal Produksi</th>
                        <th class="px-6 py-3 font-medium">Tanggal Expired</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($batches as $batch)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="px-6 py-3.5 text-subtext">{{ $loop->iteration + ($batches->currentPage() - 1) * $batches->perPage() }}</td>
                            <td class="px-6 py-3.5 font-medium text-ink">{{ $batch->batch_code }}</td>
                            <td class="px-6 py-3.5 text-ink">{{ $batch->product->name }}</td>
                            <td class="px-6 py-3.5 text-ink">{{ $batch->qr_count }}</td>
                            <td class="px-6 py-3.5 text-subtext">{{ $batch->production_date->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-3.5 text-subtext">{{ $batch->expiry_date->translatedFormat('d M Y') }}</td>
                                                       <td class="px-6 py-3.5 text-right space-x-3 whitespace-nowrap">
                                <a href="{{ route('admin.batch.show', $batch->id) }}" class="text-primary font-medium hover:underline">Detail</a>
                                @if ($batch->scanned_qr_count > 0)
                                    <form action="{{ route('admin.batch.destroy', $batch->id) }}" method="POST" class="inline" onsubmit="return confirm('PERHATIAN: Batch ini punya QR yang sudah pernah discan sebanyak {{ $batch->scanned_qr_count }} kali. Menghapusnya bisa membuat QR yang sudah beredar gagal diverifikasi. Lanjutkan hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-amber-600 font-medium hover:underline">Hapus Batch (Sudah Discan)</button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.batch.destroy', $batch->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus batch &quot;{{ $batch->batch_code }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 font-medium hover:underline">Hapus Batch</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-subtext">Belum ada batch produksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

                <div class="md:hidden divide-y divide-gray-50">
            @forelse ($batches as $batch)
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="font-medium text-ink text-sm">{{ $batch->batch_code }}</p>
                            <p class="text-xs text-subtext mt-0.5">{{ $batch->product->name }}</p>
                        </div>
                        <span class="text-xs text-subtext whitespace-nowrap">{{ $batch->qr_count }} QR</span>
                    </div>
                    <div class="flex items-center gap-4 mt-2 text-xs text-subtext">
                        <span>Produksi: {{ $batch->production_date->translatedFormat('d M Y') }}</span>
                        <span>Expired: {{ $batch->expiry_date->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-50">
                        <a href="{{ route('admin.batch.show', $batch->id) }}" class="text-primary text-sm font-medium hover:underline">Detail</a>
                        @if ($batch->scanned_qr_count > 0)
                            <form action="{{ route('admin.batch.destroy', $batch->id) }}" method="POST" onsubmit="return confirm('PERHATIAN: Batch ini punya QR yang sudah pernah discan sebanyak {{ $batch->scanned_qr_count }} kali. Menghapusnya bisa membuat QR yang sudah beredar gagal diverifikasi. Lanjutkan hapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-amber-600 text-sm font-medium hover:underline">Hapus Batch (Sudah Discan)</button>
                            </form>
                        @else
                            <form action="{{ route('admin.batch.destroy', $batch->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus batch &quot;{{ $batch->batch_code }}&quot;? Tindakan ini tidak bisa dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 text-sm font-medium hover:underline">Hapus Batch</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-subtext text-sm">Belum ada batch produksi.</div>
            @endforelse
        </div>

        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 text-sm text-subtext">
            <span>Menampilkan {{ $batches->firstItem() ?? 0 }}-{{ $batches->lastItem() ?? 0 }} dari {{ $batches->total() }} batch</span>
            <div>
                {{ $batches->links() }}
            </div>
        </div>
    </div>

    {{-- <script>
        let cariTimeout;
        document.getElementById('cariInput').addEventListener('input', function () {
            clearTimeout(cariTimeout);
            cariTimeout = setTimeout(() => this.form.submit(), 1500);
        });
    </script> --}}

        <div id="modalPilihProduk" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40" onclick="document.getElementById('modalPilihProduk').classList.add('hidden')"></div>

    <div class="relative bg-white rounded-2xl shadow-soft w-full max-w-lg max-h-[80vh] flex flex-col">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h2 class="font-display font-semibold text-lg text-ink">Pilih Produk</h2>
            <button type="button" onclick="document.getElementById('modalPilihProduk').classList.add('hidden')" class="text-subtext hover:text-ink">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="GET" action="{{ route('admin.batch.produksi-baru') }}" id="formPilihProduk" class="flex flex-col flex-1 min-h-0">
            <div class="overflow-y-auto px-6 py-4 space-y-2">
                @forelse ($productList as $p)
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-primary hover:bg-mint/10 transition cursor-pointer produk-item">
                        <input type="checkbox" name="produk_ids[]" value="{{ $p->id }}" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary/30 checkbox-produk">
                        <div class="w-12 h-12 shrink-0 rounded-lg bg-bg border border-gray-100 flex items-center justify-center overflow-hidden">
                            @if ($p->image)
                                <img src="{{ asset( $p->image) }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-6 h-6 text-primary/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3h6l1 4H8l1-4zM8 7h8l1 12a2 2 0 01-2 2H9a2 2 0 01-2-2L8 7z"/></svg>
                            @endif
                        </div>
                        <span class="text-sm font-medium text-ink">{{ $p->name }}</span>
                    </label>
                @empty
                    <p class="text-sm text-subtext text-center py-6">Belum ada produk. Tambahkan produk terlebih dahulu.</p>
                @endforelse
            </div>

            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 shrink-0">
                <span id="jumlahTerpilih" class="text-sm text-subtext">0 produk dipilih</span>
                <button type="submit" id="btnLanjutkan" disabled
                    class="px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft disabled:opacity-40 disabled:cursor-not-allowed">
                    Lanjutkan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.checkbox-produk').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const label = this.closest('.produk-item');
            if (this.checked) {
                label.classList.add('border-primary', 'bg-mint/10');
            } else {
                label.classList.remove('border-primary', 'bg-mint/10');
            }

            const jumlah = document.querySelectorAll('.checkbox-produk:checked').length;
            document.getElementById('jumlahTerpilih').textContent = jumlah + ' produk dipilih';
            document.getElementById('btnLanjutkan').disabled = jumlah === 0;
        });
    });
</script>

@endsection