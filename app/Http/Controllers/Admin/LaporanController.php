<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getReportData($request);

        return view('admin.laporan.index', $data);
    }
    public function exportPdf(Request $request)
    {
        $data = $this->getReportData($request);

        $pdf = Pdf::loadView('admin.laporan.pdf', $data);

        $filename = 'laporan-batch-produksi-' . now()->format('Ymd-His') . '.pdf';

        if ($request->boolean('download')) {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

        public function cetak(Request $request)
    {
        $data = $this->getReportData($request);

        return view('admin.laporan.cetak', $data);
    }

    private function getReportData(Request $request): array
    {
        $mulai = $request->input('mulai', now()->startOfMonth()->format('Y-m-d'));
        $akhir = $request->input('akhir', now()->endOfMonth()->format('Y-m-d'));
        $produkId = $request->input('produk', 'semua');

        $query = Batch::with('product')
            ->whereBetween('production_date', [$mulai, $akhir]);

        if ($produkId !== 'semua') {
            $query->where('product_id', $produkId);
        }

        $batches = $query->orderBy('production_date')->get();

        return [
            'batches' => $batches,
            'totalBatch' => $batches->count(),
            'totalQr' => $batches->sum('qr_count'),
            'mulai' => $mulai,
            'akhir' => $akhir,
            'produkId' => $produkId,
            'productList' => Product::orderBy('name')->get(['id', 'name']),
        ];
    }
}