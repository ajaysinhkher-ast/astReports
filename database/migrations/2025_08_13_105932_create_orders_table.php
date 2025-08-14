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
            $table->string('fulfillment_status')->default('pending');
            $table->string('financial_status')->default('pending');
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('taxes', 12, 2)->default(0);
            $table->string('email')->nullable();
            $table->boolean('is_cancelled')->default(false);
            $table->string('shipping_method')->nullable();
            $table->string('currency', 3)->default('USD');
            $table->decimal('weight', 8, 3)->default(0);
            $table->string('discount_code')->nullable();
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
