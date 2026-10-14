<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\QrCode;
use App\Services\CipherService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BatchController extends Controller
{
    public function index(Request $request)
    {
        $query = Batch::with('product');

        if ($request->filled('cari')) {
            $query->where('batch_code', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('produk') && $request->produk !== 'semua') {
            $query->where('product_id', $request->produk);
        }

        $batches = $query->withCount(['qrCodes as scanned_qr_count' => function ($q) {$q->where('scan_count', '>', 0);
        }])->latest()->paginate(5)->withQueryString();

        $productList = Product::orderBy('name')->get(['id', 'name', 'image', 'label_image', 'label_qr_x', 'label_qr_y', 'label_qr_size']);

        return view('admin.batch.index', compact('batches', 'productList'));
    }
        public function show(Request $request, Batch $batch)
    {
        $batch->load('product');

        $qrQuery = $batch->qrCodes();

        if ($request->filled('cari_qr')) {
            $qrQuery->where('serial_number', 'like', '%' . $request->cari_qr . '%');
        }

        $qrCodes = $qrQuery->orderBy('serial_number')->paginate(10)->withQueryString();

        return view('admin.batch.show', compact('batch', 'qrCodes'));
    }

        public function qrShow(Batch $batch, QrCode $qr)
    {
        if ($qr->batch_id !== $batch->id) {
            abort(404);
        }

        $batch->load('product');

        $qrString = $batch->cipher_batch . '|' . $qr->cipher_serial;

        return view('admin.batch.qr-show', compact('batch', 'qr', 'qrString'));
    }

        public function cetakLabel(Batch $batch)
    {
        $batch->load('product');

        $product = $batch->product;

        $qrCodes = $batch->qrCodes()->orderBy('serial_number')->get();

        return view('admin.batch.cetak-label', compact('batch', 'product', 'qrCodes'));
    }

        public function destroy(Batch $batch)
    {
        $namaBatch = $batch->batch_code;
        $batch->delete();

        return redirect()->route('admin.batch.index')
            ->with('success', 'Batch "' . $namaBatch . '" beserta seluruh QR Code di dalamnya berhasil dihapus.');
    }

    public function produksiBaruForm(Request $request)
{
    $produkIds = $request->query('produk_ids', []);

    if (empty($produkIds)) {
        return redirect()->route('admin.batch.index')
            ->with('error', 'Pilih minimal 1 produk terlebih dahulu.');
    }

    $products = Product::whereIn('id', $produkIds)->get();

    return view('admin.batch.produksi-baru', compact('products'));
}

    public function storeProduksiBaruMulti(Request $request, CipherService $cipherService)
    {
    $validated = $request->validate([
        'produk_ids' => 'required|array|min:1',
        'produk_ids.*' => 'exists:products,id',
        'qty' => 'required|array',
        'qty.*' => 'required|integer|min:1|max:5000',
        'tgl_produksi' => 'required|date',
        'tgl_expired' => 'required|date|after_or_equal:tgl_produksi',
    ]);

    $produkIds = $validated['produk_ids'];
    $qty = $validated['qty'];

        $tanpaLabel = Product::whereIn('id', $produkIds)->get()
        ->filter(fn ($p) => !$this->labelLengkap($p));

    if ($tanpaLabel->isNotEmpty()) {
        return redirect()->route('admin.batch.index')
            ->with('error', 'Batch tidak dibuat. Produk berikut belum punya template label: '
                . $tanpaLabel->pluck('name')->implode(', ')
                . '. Lengkapi dulu label di Edit Produk.');
    }

    DB::transaction(function () use ($produkIds, $qty, $validated, $cipherService) {
        foreach ($produkIds as $productId) {
            $jumlah = $qty[$productId];
            $batchCode = $this->generateBatchCode();

            $batch = Batch::create([
                'product_id' => $productId,
                'batch_code' => $batchCode,
                'cipher_batch' => $cipherService->encrypt($batchCode),
                'production_date' => $validated['tgl_produksi'],
                'expiry_date' => $validated['tgl_expired'],
                'qr_count' => $jumlah,
            ]);

            for ($i = 1; $i <= $jumlah; $i++) {
                $sequence = str_pad($i, 4, '0', STR_PAD_LEFT);

               $qr = QrCode::create([
                'batch_id' => $batch->id,
                'serial_number' => $batchCode . '-' . $sequence,
                'cipher_serial' => '',
                'scan_count' => 0,
                'last_scanned_at' => null,
                ]);

                $idPadded = str_pad($qr->id, 12, '0', STR_PAD_LEFT);

                $qr->update([
                    'cipher_serial' => $cipherService->encrypt('OLVQ' . $idPadded),
                ]);
            }
        }
    });

    $totalBatch = count($produkIds);
    $totalQr = array_sum($qty);

    return redirect()->route('admin.batch.index')
        ->with('success', $totalBatch . ' batch produksi & total ' . $totalQr . ' QR Code berhasil dibuat.');
}

private function labelLengkap(Product $product): bool
{
    return !empty($product->label_image)
        && $product->label_qr_x !== null
        && $product->label_qr_y !== null
        && $product->label_qr_size !== null;
}

private function generateBatchCode(): string
{
    do {
        $code = 'OLV' . now()->format('ymd') . strtoupper(Str::random(4));
    } while (Batch::where('batch_code', $code)->exists());

    return $code;
}

}
