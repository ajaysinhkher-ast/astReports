<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Osiset\ShopifyApp\Util;

class AddThemeSupportLevelToUsersTable extends Migration
{
    public function up()
    {
        Schema::table(Util::getShopsTable(), function (Blueprint $table) {
            if (!Schema::hasColumn(Util::getShopsTable(), 'theme_support_level')) {
                $table->integer('theme_support_level')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table(Util::getShopsTable(), function (Blueprint $table) {
            if (Schema::hasColumn(Util::getShopsTable(), 'theme_support_level')) {
                $table->dropColumn('theme_support_level');
            }
        });
    }
}
