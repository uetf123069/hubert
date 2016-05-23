<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWaitingToRespondToProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('providers' , function(Blueprint $table) {
            $table->integer('waiting_to_respond')->after('is_available');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('providers' , function(Blueprint $table) {
            $table->dropColumn('waiting_to_respond');
        });
    }
}
