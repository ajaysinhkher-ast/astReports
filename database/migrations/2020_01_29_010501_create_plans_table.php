<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Osiset\ShopifyApp\Util;

class CreatePlansTable extends Migration
{
    public function up()
    {
        Schema::create(Util::getShopifyConfig('table_names.plans', 'plans'), function (Blueprint $table) {
            // Use bigIncrements for better compatibility with SingleStore
            $table->bigIncrements('id');

            // The type of plan, either PlanType::RECURRING (0) or PlanType::ONETIME (1)
            $table->string('type');

            // Name of the plan
            $table->string('name');

            // Price of the plan
            $table->decimal('price', 8, 2);

            // Store the amount of the charge, nullable
            $table->decimal('capped_amount', 8, 2)->nullable();

            // Terms for usage charges, nullable
            $table->string('terms')->nullable();

            // Nullable trial days
            $table->integer('trial_days')->nullable();

            // Is a test plan or not (boolean)
            $table->boolean('test')->default(false);

            // On-install flag (boolean)
            $table->boolean('on_install')->default(false);

            // created_at and updated_at timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(Util::getShopifyConfig('table_names.plans', 'plans'));
    }
}
