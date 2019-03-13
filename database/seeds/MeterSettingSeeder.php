<?php

use Illuminate\Database\Seeder;

class MeterSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meter_setting')->insert([
            'sever_url'=>'https://www.w3schools.com/html',
            'post_int'=>'20',
            'log_file_name'=>'abc',
            'log_int'=>'30',
            'display_col1'=>"A",
            'display_col2'=>"VLN",
            'display_col3'=>"W1",
        ]);
    }
}
