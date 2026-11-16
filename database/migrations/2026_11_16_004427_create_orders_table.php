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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained();
            $table->foreignId('size_id')->constrained();
            $table->foreignId('fabric_id')->nullable()->constrained();
            $table->decimal('total_price', 12, 2);
            $table->enum('payment_type', ['dp', 'full'])->default('dp');
            $table->decimal('dp_amount', 12, 2);
            $table->decimal('remaining_amount', 12, 2);
            $table->decimal('revision_extra_cost', 12, 2)->default(0);
            $table->enum('payment_status', ['unpaid', 'dp_paid', 'paid', 'expired'])->default('unpaid');
            $table->string('payment_proof_path')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('qr_code_path')->nullable();
            $table->timestamp('qr_expires_at')->nullable();
            $table->enum('fulfillment_type', ['pickup', 'delivery']);
            $table->string('tracking_number')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamp('finishing_at')->nullable();
            $table->timestamp('rev_deadline')->nullable();
            $table->boolean('auto_confirmed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
