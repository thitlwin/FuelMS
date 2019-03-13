<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWifiSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('wifi_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('SSID');
            $table->string('password');
            $table->enum('choice1',['AP','Wifi']);
            $table->enum('choice2',['DHCP','STATIC']);
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
       Schema::drop('wifi_setting');
    }
}
