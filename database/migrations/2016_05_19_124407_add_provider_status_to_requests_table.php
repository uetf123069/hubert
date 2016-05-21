<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProviderStatusToRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('requests' , function(Blueprint $table) {
            $table->integer('provider_status')->after('status');
            $table->string('after_image');
            $table->string('before_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests' , function(Blueprint $table) {
            $table->dropColumn('provider_status');
            $table->dropColumn('after_image');
            $table->dropColumn('before_image');
        });
    }
}
