<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DashboardSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('dashboard_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('selected_device_id')->unsigned();
            $table->integer('db_update_second')->unsigned();
            $table->integer('interval_chart_second')->unsigned();
            $table->integer('chart_width')->unsigned();
            $table->integer('chart_height')->unsigned();
            $table->integer('minor_ticks')->unsigned();
            $table->integer('red_from')->unsigned();
            $table->integer('red_to')->unsigned();
            $table->integer('yellow_from')->unsigned();
            $table->integer('yellow_to')->unsigned();
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
        Schema::drop('dashboard_setting');
    }
}
