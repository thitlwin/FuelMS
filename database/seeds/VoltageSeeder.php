<?php

use Illuminate\Database\Seeder;

class VoltageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
         DB::table('voltage')->insert([
            'device_id'=>1,
            'VLL'=>202,
            'VLN'=>200,
            'V12'=>205,
            'V31'=>208,
            'V1'=>210,
            'V2'=>222,
            'V3'=>209,
        ]);
    }
}
