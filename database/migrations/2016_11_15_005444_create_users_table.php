<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agent_id')->unsigned();
            $table->integer('user_type_id')->unsigned();
            $table->string('login_name')->unique();
            $table->string('name');            
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nrc')->unique();
            $table->string('address')->nullable();
            $table->string('phone');
            $table->double('credit');            
            $table->rememberToken();
            $table->string('api_key');
            $table->timestamps();            
            $table->foreign('user_type_id')->references('id')->on('user_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
