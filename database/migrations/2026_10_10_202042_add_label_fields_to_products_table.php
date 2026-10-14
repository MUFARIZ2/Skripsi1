<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('label_image')->nullable();
            $table->decimal('label_qr_x', 5, 2)->nullable();
            $table->decimal('label_qr_y', 5, 2)->nullable();
            $table->decimal('label_qr_size', 5, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['label_image', 'label_qr_x', 'label_qr_y', 'label_qr_size']);
        });
    }
};