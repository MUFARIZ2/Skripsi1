<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Product;
use App\Models\QrCode;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Product::count();
        $totalBatch = Batch::count();
        $totalQrCode = QrCode::count();

        $batchTerbaru = Batch::with('product')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk', 'totalBatch', 'totalQrCode', 'batchTerbaru'
        ));
    }
}