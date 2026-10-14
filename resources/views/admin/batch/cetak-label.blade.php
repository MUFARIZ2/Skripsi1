@extends('layouts.admin')

@section('title', 'Cetak Label QR - Olive Verify')

@push('styles')
<style>
    .label-sheet {
        position: relative;
        width: 12cm;
        height: 20cm;
        overflow: hidden;
        background: #fff;
    }
    .label-sheet img.label-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }
    .label-sheet .label-qr {
        position: absolute;
        background: #fff;
        padding: 0.1cm;
        box-sizing: border-box;
    }
    .label-sheet .label-qr svg {
        width: 100%;
        height: 100%;
        display: block;
    }

        @media screen and (max-width: 640px) {
        .print-area { zoom: 0.68; }
    }

    @media print {
        @page { size: 12cm 20cm; margin: 0; }
        header, .no-print { display: none !important; }
        html, body { margin: 0 !important; padding: 0 !important; background: #fff !important; }
        main { max-width: none !important; margin: 0 !important; padding: 0 !important; }
        .print-area { margin: 0 !important; padding: 0 !important; }
        .print-area > * + * { margin-top: 0 !important; }
        .label-sheet { page-break-after: always; break-after: page; margin: 0 !important; box-shadow: none !important; }
        .label-sheet:last-child { page-break-after: auto; break-after: auto; }
        .overflow-x-auto { overflow: visible !important; }
    }
</style>
@endpush

@section('content')

    <div class="flex items-center gap-2 text-sm text-subtext mb-6 no-print">
        <a href="{{ route('admin.batch.index') }}" class="hover:text-primary">Batch Produksi</a>
        <span>/</span>
        <a href="{{ route('admin.batch.show', $batch->id) }}" class="hover:text-primary">Detail Batch</a>
        <span>/</span>
        <span class="text-ink font-medium">Cetak Label QR</span>
    </div>

    @if (! $product->label_image || is_null($product->label_qr_x) || is_null($product->label_qr_y) || is_null($product->label_qr_size))
        <div class="max-w-xl bg-white rounded-2xl border border-gray-50 shadow-soft p-8 no-print">
            <h1 class="font-display font-semibold text-lg text-ink mb-2">Template label belum lengkap</h1>
            <p class="text-sm text-subtext mb-5">
                Produk "{{ $product->name }}" belum punya gambar desain label atau posisi QR. Lengkapi dulu di halaman Edit Produk.
            </p>
            <a href="{{ route('admin.produk.edit', $product->id) }}" class="inline-flex px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft">Edit Produk</a>
        </div>
    @else
        <div class="no-print mb-5 flex items-center justify-between gap-4 flex-wrap">
            <div>
                <h1 class="font-display font-semibold text-lg text-ink">Cetak Label &mdash; {{ $batch->batch_code }}</h1>
                <p class="text-sm text-subtext">{{ $product->name }} &middot; {{ $qrCodes->count() }} label (1 label per halaman, 12 &times; 20 cm)</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.batch.show', $batch->id) }}" class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-ink hover:bg-bg transition">Kembali</a>
                <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-dark transition shadow-soft">Cetak</button>
            </div>
        </div>

        {{-- <p class="no-print text-xs text-subtext mb-4">
            Saat dialog cetak muncul: Margins = None, Scale = 100%, dan matikan "Headers and footers". Untuk menyimpan sebagai PDF, pilih "Save as PDF".
        </p> --}}

        <div class="overflow-x-auto">
        <div class="print-area space-y-6">
            @foreach ($qrCodes as $qr)
                <div class="label-sheet shadow-soft">
                    <img class="label-bg" src="{{ asset('storage/' . $product->label_image) }}" alt="Label">
                    <div class="label-qr"
                         style="left: {{ $product->label_qr_x }}cm; top: {{ $product->label_qr_y }}cm; width: {{ $product->label_qr_size }}cm; height: {{ $product->label_qr_size }}cm;">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->margin(0)->errorCorrection('M')->generate($batch->cipher_batch . '|' . $qr->cipher_serial) !!}
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    @endif

@endsection