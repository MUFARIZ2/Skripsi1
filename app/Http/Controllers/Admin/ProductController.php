<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\QrCode;
use App\Services\CipherService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
        public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('varian') && $request->varian !== 'semua') {
            $query->where('category', $request->varian);
        }

        $products = $query->withCount('batches')->oldest()->paginate(5)->withQueryString();

        $varianList = Product::select('category')->distinct()->pluck('category');

        return view('admin.produk.index', compact('products', 'varianList'));
    }

    public function show(Product $product)
    {
        return view('admin.produk.show', compact('product'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:products,name',
            'varian' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'komposisi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'label_image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'label_qr_x' => 'nullable|required_with:label_image|numeric|min:0|max:100',
            'label_qr_y' => 'nullable|required_with:label_image|numeric|min:0|max:100',
            'label_qr_size' => 'nullable|required_with:label_image|numeric|min:0.5|max:50',
            'label_width_cm' => 'nullable|numeric|min:1|max:100',
        ]);

        $imagePath = null;
        if ($request->hasFile('foto')) {
            $imagePath = $request->file('foto')->store('produk', 'public');
        }
        $labelPath = null;
        if ($request->hasFile('label_image')) {
            $labelPath = $request->file('label_image')->store('label', 'public');
        }

        Product::create([
            'name' => $validated['nama'],
            'category' => $validated['varian'],
            'ukuran' => $validated['ukuran'],
            'price' => $validated['harga'],
            'description' => $validated['deskripsi'] ?? null,
            'composition' => $validated['komposisi'] ?? null,
            'image' => $imagePath,
            'label_image' => $labelPath,
            'label_qr_x' => $validated['label_qr_x'] ?? null,
            'label_qr_y' => $validated['label_qr_y'] ?? null,
            'label_qr_size' => $validated['label_qr_size'] ?? null,
            'label_width_cm' => $validated['label_width_cm'] ?? null,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }


    public function edit(Product $product)
    {
        return view('admin.produk.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:products,name,' . $product->id,
            'varian' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'komposisi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'label_image' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'label_qr_x' => 'nullable|required_with:label_image|numeric|min:0|max:100',
            'label_qr_y' => 'nullable|required_with:label_image|numeric|min:0|max:100',
            'label_qr_size' => 'nullable|required_with:label_image|numeric|min:0.5|max:50',
                        'label_width_cm' => 'nullable|numeric|min:1|max:100',
            ]);

        $imagePath = $product->image;

        if ($request->hasFile('foto')) {
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('foto')->store('produk', 'public');
        }

        $labelPath = $product->label_image;
        if ($request->hasFile('label_image')) {
            if ($product->label_image) {
                \Storage::disk('public')->delete($product->label_image);
            }
            $labelPath = $request->file('label_image')->store('label', 'public');
        }

        $product->update([
            'name' => $validated['nama'],
            'category' => $validated['varian'],
            'ukuran' => $validated['ukuran'],
            'price' => $validated['harga'],
            'description' => $validated['deskripsi'] ?? null,
            'composition' => $validated['komposisi'] ?? null,
            'image' => $imagePath,
            'label_image' => $labelPath,
            'label_qr_x' => $validated['label_qr_x'] ?? null,
            'label_qr_y' => $validated['label_qr_y'] ?? null,
            'label_qr_size' => $validated['label_qr_size'] ?? null,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

        public function destroy(Product $product)
    {
        if ($product->batches()->exists()) {
            return redirect()->route('admin.produk.index')
                ->with('error', 'Produk "' . $product->name . '" tidak bisa dihapus karena sudah memiliki riwayat batch produksi. Hapus dulu batch terkait jika benar-benar ingin menghapus produk ini.');
        }

        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk "' . $product->name . '" berhasil dihapus.');
    }
    
        public function produksiBaru(Product $product)
    {
        $previewBatchCode = $this->generateBatchCode();

        return view('admin.produk.produksi-baru', compact('product', 'previewBatchCode'));
    }

    public function storeProduksiBaru(Request $request, Product $product, CipherService $cipherService)
    {
        $validated = $request->validate([
            'jumlah' => 'required|integer|min:1|max:5000',
            'tgl_produksi' => 'required|date',
            'tgl_expired' => 'required|date|after:tgl_produksi',
        ]);

        $batchCode = $this->generateBatchCode();

        DB::transaction(function () use ($product, $validated, $batchCode, $cipherService) {
        $batch = Batch::create([
                'product_id' => $product->id,
                'batch_code' => $batchCode,
                'cipher_batch' => $cipherService->encrypt($batchCode),
                'production_date' => $validated['tgl_produksi'],
                'expiry_date' => $validated['tgl_expired'],
                'qr_count' => $validated['jumlah'],
            ]);

            $now = now();
            $rows = [];

            for ($i = 1; $i <= $validated['jumlah']; $i++) {
                $sequence = str_pad($i, 4, '0', STR_PAD_LEFT);

                $rows[] = [
                    'batch_id' => $batch->id,
                    'serial_number' => $batchCode . '-' . $sequence,
                    'cipher_serial' => $cipherService->encrypt($sequence),
                    'scan_count' => 0,
                    'last_scanned_at' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

                       foreach (array_chunk($rows, 500) as $chunk) {
                QrCode::insert($chunk);
            }

            return $batch;
        });

    return redirect()->route('admin.batch.index')
    ->with('success', 'Batch produksi & ' . $validated['jumlah'] . ' QR Code berhasil dibuat.');
    }

    private function generateBatchCode(): string
    {
        do {
            $code = 'B' . now()->format('ymd') . strtoupper(Str::random(4));
        } while (Batch::where('batch_code', $code)->exists());

        return $code;
    }
}