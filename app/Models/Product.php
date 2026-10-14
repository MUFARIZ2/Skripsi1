<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

            protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'category',
        'ukuran',
        'composition',
        'price',
        'label_image',
        'label_qr_x',
        'label_qr_y',
        'label_qr_size',
        'label_width_cm',
    ];

    /**
     * Otomatis bikin slug dari nama produk saat data disimpan.
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    /**
     * Relasi: satu produk punya banyak batch.
     */
    public function batches(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Batch::class);
    }
}