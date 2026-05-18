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

            // 🔗 user yang order
            $table->foreignId('user_id')->nullable();

            // 👤 data customer
            $table->string('customer_name');
            $table->string('phone');
            $table->text('address');

            // 💰 total
            $table->integer('total_price');

            // 📦 status order
            $table->string('status')->default('pending');

            // 💳 pembayaran
            $table->string('payment_method')->nullable();

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