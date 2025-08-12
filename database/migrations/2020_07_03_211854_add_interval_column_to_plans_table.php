<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Osiset\ShopifyApp\Util;

class AddIntervalColumnToPlansTable extends Migration
{
    public function up()
    {
        Schema::table(Util::getShopifyConfig('table_names.plans', 'plans'), function (Blueprint $table) {
            if (!Schema::hasColumn(Util::getShopifyConfig('table_names.plans', 'plans'), 'interval')) {
                $table->string('interval')->nullable()->after('price');
            }
        });
    }

    public function down()
    {
        Schema::table(Util::getShopifyConfig('table_names.plans', 'plans'), function (Blueprint $table) {
            if (Schema::hasColumn(Util::getShopifyConfig('table_names.plans', 'plans'), 'interval')) {
                $table->dropColumn('interval');
            }
        });
    }
}
