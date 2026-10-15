<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\QrCode;
use App\Services\CipherService;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function __construct(protected CipherService $cipherService)
    {
    }

 public function cek(Request $request)
{
    $request->validate([
        'kode' => 'required|string',
    ]);

    $parts = explode('|', $request->input('kode'));

    if (count($parts) !== 2) {
        return redirect()->route('verifikasi.hasil-invalid')->with('alasan', 'tidak_ditemukan');
    }

    [$cipherBatch, $cipherSerial] = $parts;

    $batchCode = $this->cipherService->decrypt($cipherBatch);
    $decryptedSerial = $this->cipherService->decrypt($cipherSerial);

    if ($batchCode === null || $decryptedSerial === null) {
        return redirect()->route('verifikasi.hasil-invalid')->with('alasan', 'tidak_ditemukan');
    }
        
    if (!str_starts_with($decryptedSerial, 'OLVQ')) {
        return redirect()->route('verifikasi.hasil-invalid')->with('alasan', 'tidak_ditemukan');
    }
        
    $qrId = (int) substr($decryptedSerial, 4);
        
    if ($qrId <= 0) {
        return redirect()->route('verifikasi.hasil-invalid')->with('alasan', 'tidak_ditemukan');
    }
        
    $batch = Batch::with('product')->where('batch_code', $batchCode)->first();
    if (!$batch) {
        return redirect()->route('verifikasi.hasil-invalid')->with('alasan', 'tidak_ditemukan');
    }

    $qrCode = QrCode::where('id', $qrId)
        ->where('batch_id', $batch->id)
        ->first();

    if (!$qrCode) {
        return redirect()->route('verifikasi.hasil-invalid')->with('alasan', 'tidak_ditemukan');
    }

    $qrCode->increment('scan_count');
    $qrCode->update(['last_scanned_at' => now()]);

    $dataVerifikasi = [
        'nama_produk' => $batch->product->name,
        'varian' => $batch->product->category,
        'ukuran' => $batch->product->ukuran,
        'komposisi' => $batch->product->composition,
        'kode_batch' => $batch->batch_code,
        'serial_qr' => $qrCode->serial_number,
        'tanggal_produksi' => $batch->production_date->translatedFormat('d F Y'),
        'tanggal_kedaluwarsa' => $batch->expiry_date->translatedFormat('d F Y'),
    ];

    $warningLimit = config('verifikasi.scan_limit_warning');
    $pemalsuanLimit = config('verifikasi.scan_limit_pemalsuan');

    if ($qrCode->scan_count >= $pemalsuanLimit) {
        return redirect()->route('verifikasi.hasil-invalid')->with('alasan', 'pemalsuan');
    }

    if ($qrCode->scan_count >= $warningLimit) {
        return redirect()->route('verifikasi.hasil-warning')->with('data_verifikasi', $dataVerifikasi);
    }

    return redirect()->route('verifikasi.hasil-asli')->with('data_verifikasi', $dataVerifikasi);
}
}