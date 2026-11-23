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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Relasi ke pesanan utama
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relasi ke produk/layanan
            $table->foreignId('service_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Informasi produk saat dibeli
            $table->string('product_name');
            $table->string('product_image')->nullable();

            // Harga dan jumlah produk
            $table->decimal('unit_price', 12, 2);
            $table->unsignedInteger('quantity')->default(1);

            // Variasi produk
            $table->string('color')->nullable();

            // Ukuran standar atau custom
            $table->string('size_type', 20)->default('standard');
            $table->string('size_label')->nullable();

            // Detail ukuran custom
            $table->json('custom_measurements')->nullable();

            // Total harga untuk item ini
            $table->decimal('line_total', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
