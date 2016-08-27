<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletedAtProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        Schema::table('providers' , function(Blueprint $table) {
            $table->timestamp('deleted_at')->after('updated_at');
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
            $table->dropColumn('deleted_at');
            });
    }
}
