@extends('layouts.admin')

@section('title', 'Detail QR Code - Olive Verify')

@push('styles')
<style>
    @media print {
        @page { margin: 10mm; }
        body { background: #fff !important; }
        header, .no-print { display: none !important; }
        main > * , main { visibility: hidden; }
        #areaCetakQr, #areaCetakQr * { visibility: visible; }
        #areaCetakQr {
            position: absolute; left: 0; top: 0;
            border: none !important; box-shadow: none !important;
            padding: 0 !important; background: #fff !important;
        }
        #qrBungkus {
            width: 3cm !important; height: 3cm !important;
            border: none !important; background: #fff !important;
            margin: 0 auto 2mm auto !important;
            padding: 1mm; aspect-ratio: auto !important;
        }
        #qrBungkus svg { width: 100% !important; height: 100% !important; }
    }
</style>
@endpush
@section('content')

    <div class="flex items-center gap-2 text-sm text-subtext mb-6 flex-wrap">
        <a href="{{ route('admin.batch.index') }}" class="hover:text-primary">Batch Produksi</a>
        <span>/</span>
        <a href="{{ route('admin.batch.show', $batch->id) }}" class="hover:text-primary">Detail Batch</a>
        <span>/</span>
        <span class="text-ink font-medium">Detail QR Code</span>
    </div>

    <div class="grid lg:grid-cols-[280px_1fr] gap-6">

        {{-- QR besar --}}
                <div id="areaCetakQr" class="bg-white rounded-2xl border border-gray-50 shadow-soft p-6 text-center h-fit">
                        <div id="qrBungkus" class="w-full aspect-square rounded-xl bg-bg border border-gray-100 flex items-center justify-center mb-4 overflow-hidden">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(240)->generate($qrString) !!}
            </div>
            {{-- <p class="font-display font-semibold text-lg text-ink mb-4">{{ $qr->serial_number }}</p> --}}
            <p class="font-display font-semibold text-lg text-ink mb-4">{{ 'OLVQ' . str_pad($qr->id, 12, '0', STR_PAD_LEFT) }}</p>
            <button type="button" onclick="window.print()" class="w-full py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition no-print">Cetak QR</button>
        </div>

        <div class="space-y-6">
            {{-- info produk --}}
            <div class="bg-white rounded-2xl border border-gray-50 shadow-soft p-6">
                <h2 class="font-semibold text-ink mb-4">Informasi Produk</h2>
                <dl class="grid sm:grid-cols-3 gap-y-3 text-sm">
                    <div><dt class="text-subtext mb-0.5">Nama Produk</dt><dd class="font-medium text-ink">{{ $batch->product->name }}</dd></div>
                    <div><dt class="text-subtext mb-0.5">Varian</dt><dd class="font-medium text-ink">{{ $batch->product->category }}</dd></div>
                    <div><dt class="text-subtext mb-0.5">Ukuran</dt><dd class="font-medium text-ink">{{ $batch->product->ukuran }}</dd></div>
                </dl>
            </div>

            {{-- info produksi --}}
            <div class="bg-white rounded-2xl border border-gray-50 shadow-soft p-6">
                <h2 class="font-semibold text-ink mb-4">Informasi Produksi</h2>
                <dl class="grid sm:grid-cols-3 gap-y-3 text-sm">
                    <div><dt class="text-subtext mb-0.5">Kode Batch</dt><dd class="font-medium text-ink">{{ $batch->batch_code }}</dd></div>
                    <div><dt class="text-subtext mb-0.5">Tanggal Produksi</dt><dd class="font-medium text-ink">{{ $batch->production_date->translatedFormat('d F Y') }}</dd></div>
                    <div><dt class="text-subtext mb-0.5">Tanggal Expired</dt><dd class="font-medium text-ink">{{ $batch->expiry_date->translatedFormat('d F Y') }}</dd></div>
                </dl>
            </div>

            {{-- info qr --}}
            <div class="bg-white rounded-2xl border border-gray-50 shadow-soft p-6">
                <h2 class="font-semibold text-ink mb-4">Informasi QR</h2>
                <dl class="grid sm:grid-cols-2 gap-y-3 text-sm">
                    {{-- <div><dt class="text-subtext mb-0.5">Serial QR</dt><dd class="font-medium text-ink">{{ $qr->serial_number }}</dd></div> --}}
                    <div><dt class="text-subtext mb-0.5">Serial QR</dt><dd class="font-medium text-ink">{{ 'OLVQ' . str_pad($qr->id, 12, '0', STR_PAD_LEFT) }}</dd></div>
                    <div><dt class="text-subtext mb-0.5">Tanggal Dibuat</dt><dd class="font-medium text-ink">{{ $qr->created_at->translatedFormat('d F Y, H:i') }}</dd></div>
                </dl>
            </div>

            {{-- info enkripsi - HANYA ADMIN --}}
            <div class="bg-white rounded-2xl border border-warning/20 shadow-soft p-6">
                <div class="flex items-center gap-2 mb-4">
                    <h2 class="font-semibold text-ink">Data Enkripsi</h2>
                    <span class="px-2 py-0.5 rounded-full bg-warning/10 text-warning text-xs font-semibold">Khusus Admin</span>
                </div>
                <dl class="grid sm:grid-cols-2 gap-y-3 text-sm">
                    <div>
                        <dt class="text-subtext mb-0.5">Cipher Batch</dt>
                        <dd class="font-mono text-xs text-ink bg-bg px-2 py-1 rounded-lg inline-block break-all">{{ $batch->cipher_batch }}</dd>
                    </div>
                    <div>
                        <dt class="text-subtext mb-0.5">Cipher Serial</dt>
                        <dd class="font-mono text-xs text-ink bg-bg px-2 py-1 rounded-lg inline-block break-all">{{ $qr->cipher_serial }}</dd>
                    </div>
                </dl>
                <p class="text-xs text-subtext mt-3">Data ini tidak pernah ditampilkan kepada pengguna umum.</p>
            </div>
        </div>
    </div>

@endsection