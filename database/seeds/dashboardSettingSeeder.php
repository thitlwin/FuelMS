<?php

use Illuminate\Database\Seeder;

class dashboardSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('dashboard_setting')->insert([
            'user_id'=>'2',
            'selected_device_id'=>'1',
            'db_update_second'=>'10',
            'interval_chart_second'=>'5',
            'chart_width'=>'500',
            'chart_height'=>'150',
            'minor_ticks'=>'5',
            'red_from'=>'90',
            'red_to'=>'100',
            'yellow_from'=>'75',
            'yellow_to'=>'90',
        ]);
    }
}
