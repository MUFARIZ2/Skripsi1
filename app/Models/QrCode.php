<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrCode extends Model
{
    use HasFactory;

    protected $table = 'qr_codes';

    protected $fillable = [
        'batch_id',
        'serial_number',
        'cipher_serial',
        'scan_count',
        'last_scanned_at',
    ];

    protected $casts = [
        'last_scanned_at' => 'datetime',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }

    public static function verifyUrl(string $cipherBatch, string $cipherSerial): string
    {
        return rtrim(config('app.url'), '/') . '/verifikasi?kode=' . urlencode($cipherBatch . '|' . $cipherSerial);
    }
}