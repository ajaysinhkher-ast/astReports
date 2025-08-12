<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Osiset\ShopifyApp\Util;

class AddPasswordUpdatedAtToUsersTable extends Migration
{
    public function up()
    {
        Schema::table(Util::getShopsTable(), function (Blueprint $table) {
            if (!Schema::hasColumn(Util::getShopsTable(), 'password_updated_at')) {
                $table->date('password_updated_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table(Util::getShopsTable(), function (Blueprint $table) {
            if (Schema::hasColumn(Util::getShopsTable(), 'password_updated_at')) {
                $table->dropColumn('password_updated_at');
            }
        });
    }
}
