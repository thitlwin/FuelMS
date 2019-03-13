<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
    	DB::table('setting')->insert([
            'user_id'=>'2',
            'devicePref'=>'{"0":"A","1":"VLL","2":"W","3":"VA","4":"PF","5":"F","6":"FVAh","7":"PD"}',
            'reportPref'=>'{"0":"A1","1":"VLN","2":"W2","3":"VA1","4":"PF1","5":"F","6":"FWh","7":"RD"}',
            'unitPref'=>'{"w_report_unit":"W","wh_report_unit":"W","dashboard_unit":"W"}'
            ]);
    }
}
