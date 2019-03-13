<?php

use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            'id'=>'0',
            'location_name'=>'Select All',
        ]);

         DB::table('locations')->insert([
            'id'=>'1',
            'location_name'=>'All',
        ]);
    }
}
