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
            $table->string('title');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 12, 2)->default(0);  // sale price for this item
            $table->decimal('cost', 12, 2)->default(0);   // vendor cost or base cost for item
            $table->string('vendor')->nullable();
            $table->string('fulfillment_status')->default('pending');
            $table->decimal('tax', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('weight', 8, 3)->default(0);
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
