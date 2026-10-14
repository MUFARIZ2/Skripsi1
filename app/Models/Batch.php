<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'batch_code',
        'cipher_batch',
        'production_date',
        'expiry_date',
        'qr_count',
    ];

    protected $casts = [
        'production_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function qrCodes(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(QrCode::class);
}

}
