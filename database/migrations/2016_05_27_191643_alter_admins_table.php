<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('admins' , function(Blueprint $table) {
            $table->string('token');
            $table->string('token_expiry');
            $table->string('device_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('admins' , function(Blueprint $table) {
            $table->dropColumn('token');
            $table->dropColumn('token_expiry');
            $table->dropColumn('device_token');
        });
    }
}
