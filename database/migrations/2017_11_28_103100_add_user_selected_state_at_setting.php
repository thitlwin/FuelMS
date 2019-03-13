<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserSelectedStateAtSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting', function (Blueprint $table) {
            $table->string('selected_state_w_report')->nullable();
            $table->string('selected_state_wh_report_by_hour')->nullable();
            $table->string('selected_state_wh_report_by_day')->nullable();
            $table->string('selected_state_wh_report_by_month')->nullable();
            $table->string('selected_state_wh_report_by_date_range')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting', function (Blueprint $table) {
            $table->dropColumn(['selected_state_wh_report','selected_state_wh_report_by_hour','selected_state_wh_report_by_day','selected_state_wh_report_by_date_range']);
        });
    }
}
