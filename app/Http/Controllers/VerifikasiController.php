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

        $decryptedSerial = $this->cipherService->decrypt(trim($request->input('kode')));

        if ($decryptedSerial === null || !str_starts_with($decryptedSerial, 'OLVQ')) {
            return redirect()->route('verifikasi.hasil-invalid')->with('alasan', 'tidak_ditemukan');
        }

        $qrId = (int) substr($decryptedSerial, 4);

        if ($qrId <= 0) {
            return redirect()->route('verifikasi.hasil-invalid')->with('alasan', 'tidak_ditemukan');
        }

        $qrCode = QrCode::with('batch.product')->find($qrId);

        if (!$qrCode || !$qrCode->batch || !$qrCode->batch->product) {
            return redirect()->route('verifikasi.hasil-invalid')->with('alasan', 'tidak_ditemukan');
        }

        $batch = $qrCode->batch;

        $qrCode->increment('scan_count');
        $qrCode->update(['last_scanned_at' => now()]);

        $dataVerifikasi = [
            'nama_produk' => $batch->product->name,
            'varian' => $batch->product->category,
            'ukuran' => $batch->product->ukuran,
            'foto' => $batch->product->image ? asset($batch->product->image) : null,
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