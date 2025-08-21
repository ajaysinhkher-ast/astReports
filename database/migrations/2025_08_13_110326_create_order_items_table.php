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
            $table->unsignedBigInteger('order_id')->index();
            $table->string('product_name');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 12, 2)->default(0);
            $table->decimal('total_price',12,2)->default(0);
            $table->decimal('total_discount', 12, 2)->default(0);
            $table->boolean('taxable')->default(false);
            $table->decimal('total_tax', 12, 3)->default(0);
            $table->decimal('tax_rate', 8, 2)->default(0);
            $table->decimal('tax_rate_percentage', 8, 2)->default(0);
            $table->string('tax_source')->nullable();
            $table->string('sku')->nullable();
            $table->string('vendor')->nullable();
            $table->string('variant_title')->nullable();
            $table->boolean('require_shipping')->default(false);
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
