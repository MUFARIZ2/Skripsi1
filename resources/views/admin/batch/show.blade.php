@extends('layouts.admin')

@section('title', 'Detail Batch - Olive Verify')

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

    <div class="flex items-center justify-between gap-4 mb-6 flex-wrap">
        <div class="flex items-center gap-2 text-sm text-subtext">
            <a href="{{ route('admin.batch.index') }}" class="hover:text-primary">Batch Produksi</a>
            <span>/</span>
            <span class="text-ink font-medium">Detail Batch</span>
        </div>
        <a href="{{ route('admin.batch.cetak-label', $batch->id) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-200 text-sm font-semibold text-ink hover:bg-bg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M6 9V4h12v5M6 18h12v4H6v-4zm-2-6h16a2 2 0 012 2v4H2v-4a2 2 0 012-2z"/></svg>
            Cetak Label QR
        </a>
    </div>

    {{-- info batch --}}
    <div class="bg-white rounded-2xl border border-gray-50 shadow-soft p-6 flex flex-wrap gap-6 items-center mb-6">
        <div class="w-16 h-16 rounded-xl bg-bg border border-gray-100 flex items-center justify-center shrink-0 overflow-hidden">
            @if ($batch->product->image)
                <img src="{{ asset( $batch->product->image) }}" alt="{{ $batch->product->name }}" class="w-full h-full object-cover">
            @else
                <svg class="w-8 h-8 text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3h6l1 4H8l1-4zM8 7h8l1 12a2 2 0 01-2 2H9a2 2 0 01-2-2L8 7z"/></svg>
            @endif
        </div>
        <div>
    <h1 class="font-display font-semibold text-lg text-ink">{{ $batch->product->name }}</h1>
    {{-- <p class="text-sm text-subtext">{{ $batch->product->ukuran }}</p> --}}
</div>
        <div class="flex-1"></div>
        <dl class="grid grid-cols-2 sm:grid-cols-4 gap-x-8 gap-y-3 text-sm">
            @foreach ([
                'Kode Batch' => $batch->batch_code,
                'Jumlah QR' => $batch->qr_count,
                'Tanggal Produksi' => $batch->production_date->translatedFormat('d F Y'),
                'Tanggal Expired' => $batch->expiry_date->translatedFormat('d F Y'),
            ] as $label => $value)
                 <div>
                    <dt class="text-subtext mb-0.5">{{ $label }}</dt>
                    <dd class="font-medium text-ink">{{ $value }}</dd>
                </div> 
            @endforeach
        </dl>
    </div>

    {{-- daftar qr --}}
    <div class="bg-white rounded-2xl border border-gray-50 shadow-soft overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 gap-3 flex-wrap">
            <h2 class="font-semibold text-ink">Daftar QR Code</h2>
            <form method="GET" action="{{ route('admin.batch.show', $batch->id) }}" class="relative w-full sm:w-64">
                <svg class="w-4 h-4 text-subtext absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="cari_qr" id="cariQrInput" value="{{ request('cari_qr') }}" placeholder="Cari Serial QR..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-subtext border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">No</th>
                        <th class="px-6 py-3 font-medium">Serial QR</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($qrCodes as $qr)
                        <tr class="border-b border-gray-50 last:border-0">
                            <td class="px-6 py-3.5 text-subtext">{{ $loop->iteration + ($qrCodes->currentPage() - 1) * $qrCodes->perPage() }}</td>
                            <td class="px-6 py-3.5 font-medium text-ink">{{ $qr->serial_number }}</td>
                            <td class="px-6 py-3.5 text-right">
                                <a href="{{ route('admin.batch.qr-show', ['batch' => $batch->id, 'qr' => $qr->id]) }}" class="text-primary font-medium hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-subtext">Tidak ada QR Code ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 text-sm text-subtext">
            <span>Menampilkan {{ $qrCodes->firstItem() ?? 0 }}-{{ $qrCodes->lastItem() ?? 0 }} dari {{ $qrCodes->total() }} QR</span>
            <div>
                {{ $qrCodes->links() }}
            </div>
        </div>
    </div>

    <script>
        let cariQrTimeout;
        document.getElementById('cariQrInput').addEventListener('input', function () {
            clearTimeout(cariQrTimeout);
            cariQrTimeout = setTimeout(() => this.form.submit(), 1500);
        });
    </script>

@endsection