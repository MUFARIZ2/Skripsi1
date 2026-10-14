@extends('layouts.admin')

@section('title', 'Laporan - Olive Verify')

@section('content')

    <div class="mb-6">
        <h1 class="font-display font-semibold text-2xl text-ink">Laporan</h1>
        <p class="text-sm text-subtext mt-1">Buat dan cetak laporan batch produksi.</p>
    </div>

    {{-- filter --}}
    <form method="GET" class="bg-white rounded-2xl border border-gray-50 shadow-soft p-6 mb-6">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
            {{-- <div>
                <label class="block text-xs font-medium text-subtext mb-1.5">Jenis Laporan</label>
                <select name="jenis" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                    <option>Laporan Batch Produksi</option>
                </select>
            </div> --}}
            <div>
                <label class="block text-xs font-medium text-subtext mb-1.5">Produk</label>
                <select name="produk" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                    <option value="semua" {{ $produkId === 'semua' ? 'selected' : '' }}>Semua Produk</option>
                    @foreach ($productList as $p)
                        <option value="{{ $p->id }}" {{ (string) $produkId === (string) $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-subtext mb-1.5">Tanggal Mulai</label>
                <input type="date" name="mulai" value="{{ $mulai }}" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
            </div>
            <div>
                <label class="block text-xs font-medium text-subtext mb-1.5">Tanggal Akhir</label>
                <input type="date" name="akhir" value="{{ $akhir }}" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
            </div>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft">Tampilkan</button>
        </div>
    </form>

    {{-- hasil laporan --}}
    <div class="bg-white rounded-2xl border border-gray-50 shadow-soft overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 text-center">
            <h2 class="font-display font-semibold text-ink">Laporan Batch Produksi</h2>
            <p class="text-sm text-subtext">Periode: {{ \Carbon\Carbon::parse($mulai)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($akhir)->translatedFormat('d F Y') }}</p>
        </div>

        <div class="overflow-x-auto hidden md:block">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-subtext border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">No</th>
                        <th class="px-6 py-3 font-medium">Kode Batch</th>
                        <th class="px-6 py-3 font-medium">Produk</th>
                        <th class="px-6 py-3 font-medium">Jumlah QR</th>
                        <th class="px-6 py-3 font-medium">Tgl Produksi</th>
                        <th class="px-6 py-3 font-medium">Tgl Expired</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($batches as $i => $batch)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="px-6 py-3.5 text-subtext">{{ $i + 1 }}</td>
                            <td class="px-6 py-3.5 font-medium text-ink">{{ $batch->batch_code }}</td>
                            <td class="px-6 py-3.5 text-ink">{{ $batch->product->name }}</td>
                            <td class="px-6 py-3.5 text-ink">{{ $batch->qr_count }}</td>
                            <td class="px-6 py-3.5 text-subtext">{{ $batch->production_date->translatedFormat('d M Y') }}</td>
                            <td class="px-6 py-3.5 text-subtext">{{ $batch->expiry_date->translatedFormat('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-subtext">Tidak ada batch pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bg-bg font-semibold text-ink">
                        <td class="px-6 py-3.5" colspan="2">Total Batch: {{ $totalBatch }}</td>
                        <td class="px-6 py-3.5" colspan="4">Total QR: {{ number_format($totalQr, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

                <div class="md:hidden divide-y divide-gray-50">
            @forelse ($batches as $i => $batch)
                <div class="px-6 py-4">
                    <p class="text-sm font-medium text-ink">{{ $batch->batch_code }} &middot; {{ $batch->product->name }}</p>
                    <p class="text-xs text-subtext mt-1">{{ $batch->qr_count }} QR &middot; Produksi {{ $batch->production_date->translatedFormat('d M Y') }} &middot; Exp {{ $batch->expiry_date->translatedFormat('d M Y') }}</p>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-subtext text-sm">Tidak ada batch pada periode ini.</div>
            @endforelse
            @if ($batches->count())
                <div class="px-6 py-4 bg-bg text-sm font-semibold text-ink">
                    <p>Total Batch: {{ $totalBatch }}</p>
                    <p>Total QR: {{ number_format($totalQr, 0, ',', '.') }}</p>
                </div>
            @endif
        </div>

        <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
                        <a href="{{ route('admin.laporan.cetak', ['mulai' => $mulai, 'akhir' => $akhir, 'produk' => $produkId]) }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-ink hover:bg-bg transition">Cetak</a>
            <a href="{{ route('admin.laporan.pdf', ['mulai' => $mulai, 'akhir' => $akhir, 'produk' => $produkId, 'download' => 1]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17v2a2 2 0 002 2h14a2 2 0 002-2v-2"/></svg>Export PDF</a>
            
            {{-- <div class="relative">
                <button id="exportBtn" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition">
                    Export
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="exportMenu" class="hidden absolute right-0 bottom-full mb-2 w-36 bg-white rounded-xl shadow-soft border border-gray-100 py-1.5">
                    <a href="{{ route('admin.laporan.pdf', ['mulai' => $mulai, 'akhir' => $akhir, 'produk' => $produkId, 'download' => 1]) }}" class="block px-4 py-2 text-sm text-ink hover:bg-bg">PDF</a>
                </div>
            </div> --}}
        </div>
    </div>

    {{-- <script>
    const exportBtn = document.getElementById('exportBtn');
    const exportMenu = document.getElementById('exportMenu');
    exportBtn?.addEventListener('click', (e) => { e.stopPropagation(); exportMenu.classList.toggle('hidden'); });
    document.addEventListener('click', () => exportMenu?.classList.add('hidden'));
    </script> --}}

@endsection