<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            // Galeri foto produk
            $table->json('gallery_images')->nullable();

            // Pilihan warna produk
            $table->json('available_colors')->nullable();

            // Pilihan ukuran standar: S, M, L, XL, XXL
            $table->json('standard_sizes')->nullable();

            // Apakah produk menerima ukuran custom
            $table->boolean('allow_custom_size')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'gallery_images',
                'available_colors',
                'standard_sizes',
                'allow_custom_size',
            ]);
        });
    }
};
