<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsApprovedPaymentFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('name');
            $table->string('last_name')->after('first_name');
            $table->integer('is_approved');
            $table->integer('payment_mode');
            $table->integer('default_card');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
           $table->dropColumn('first_name');
           $table->dropColumn('last_name');
           $table->dropColumn('is_approved');
           $table->dropColumn('payment_mode');
           $table->dropColumn('default_card');
        });
    }
}
