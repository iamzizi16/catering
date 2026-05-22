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

            // USER YANG ORDER
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // DATA CUSTOMER
            $table->string('customer_name');
            $table->string('phone');
            $table->text('address');

            // TOTAL HARGA
            $table->integer('total_price');

            // STATUS ORDER (termasuk status pengiriman/shipping)
            $table->enum('status', [
                'pending',
                'process',
                'shipping',
                'done',
                'cancel'
            ])->default('pending');

            // PAYMENT
            $table->string('payment_method');

            // BUKTI FOTO PENGIRIMAN KURIR
            $table->string('proof_image')->nullable();

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