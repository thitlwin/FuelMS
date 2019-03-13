<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeterSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meter_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sever_url');
            $table->dateTime('post_int');
            $table->string('log_file_name');
            $table->dateTime('log_int');
            $table->string('display_col1');
            $table->string('display_col2');
            $table->string('display_col3');
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
       Schema::drop('meter_setting');
    }
}
