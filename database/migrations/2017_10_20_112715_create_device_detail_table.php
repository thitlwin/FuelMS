<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('device_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned();
            $table->double('A',64,2);
            $table->double('A1',64,2);
            $table->double('A2',64,2);
            $table->double('A3',64,2);
            $table->double('VLL',64,2);
            $table->double('VLN',64,2);
            $table->double('V12',64,2);
            $table->double('V23',64,2);
            $table->double('V31',64,2);
            $table->double('V1',64,2);
            $table->double('V2',64,2);
            $table->double('V3',64,2);
            $table->double('W',64,2);
            $table->double('W1',64,2);
            $table->double('W2',64,2);
            $table->double('W3',64,2);
            $table->double('VAR',64,2);
            $table->double('VAR1',64,2);
            $table->double('VAR2',64,2);
            $table->double('VAR3',64,2);
            $table->double('VA',64,2);
            $table->double('VA1',64,2);
            $table->double('VA2',64,2);
            $table->double('VA3',64,2);
            $table->double('PF',64,2);
            $table->double('PF1',64,2);
            $table->double('PF2',64,2);
            $table->double('PF3',64,2);
            $table->double('F',64,2);
            $table->double('FVAh',64,2);
            $table->double('FWh',64,2);
            $table->double('FVARh',64,2);
            $table->double('RVAh',64,2);
            $table->double('RWh',64,2);
            $table->double('RVARh',64,2);
            $table->double('OnH',64,2);
            $table->double('FRun',64,2);
            $table->double('RRun',64,2);
            $table->double('INTR',64,2);
            $table->double('PD',64,2);
            $table->double('RD',64,2);
            $table->double('MaxMD',64,2);
            $table->double('MaxDM',64,2);
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
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
       Schema::drop('device_detail');
    }
}
