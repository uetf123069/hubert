<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('picture');
            $table->string('token');
            $table->string('token_expire');
            $table->string('device_token');
            $table->enum('device_type',array('android','ios'));
            $table->enum('login_by',array('manual','facebook','google'));
            $table->string('social_unique_id');
            $table->string('fb_lg');
            $table->string('gl_lg');
            $table->string('description');
            $table->integer('is_activated');
            $table->integer('is_approved');
            $table->integer('is_available');
            $table->enum('gender',array('male','female','others'));
            $table->string('mobile');
            $table->double('latitude', 15, 8);
            $table->double('longitude',15,8);
            $table->string('paypal_email');
            $table->string('address');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Scheman::drop('providers');
    }
}
