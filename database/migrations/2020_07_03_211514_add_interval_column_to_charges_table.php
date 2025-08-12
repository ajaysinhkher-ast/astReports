<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Osiset\ShopifyApp\Util;

class AddIntervalColumnToChargesTable extends Migration
{
    public function up()
    {
        Schema::table(Util::getShopifyConfig('table_names.charges', 'charges'), function (Blueprint $table) {
            if (!Schema::hasColumn(Util::getShopifyConfig('table_names.charges', 'charges'), 'interval')) {
                $table->string('interval')->nullable()->after('price');
            }
        });
    }

    public function down()
    {
        Schema::table(Util::getShopifyConfig('table_names.charges', 'charges'), function (Blueprint $table) {
            if (Schema::hasColumn(Util::getShopifyConfig('table_names.charges', 'charges'), 'interval')) {
                $table->dropColumn('interval');
            }
        });
    }
}
