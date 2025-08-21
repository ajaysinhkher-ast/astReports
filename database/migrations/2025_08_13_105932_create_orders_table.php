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
            $table->unsignedBigInteger('user_id');
            $table->string('email')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('fulfillment_status')->default('pending');
            $table->string('financial_status')->default('pending');
            $table->decimal('subtotal_price', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2)->default(0);
            $table->decimal('total_taxes', 12, 2)->default(0);
            $table->decimal('total_weight', 8, 3)->default(0);
            $table->decimal('total_shipping_price', 12, 2)->default(0);
            $table->decimal('total_discount', 12, 2)->default(0);
            $table->dateTime('cancelled_at')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->string('currency', 3)->default('USD');
            $table->string('payment_method')->nullable();
            $table->dateTime('cancle_at')->nullable();
            $table->string('cancel_reason')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->timestamps();
            $table->softDeletes();
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
