<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // user types
         DB::table('user_types')->insert([
            'name'=>'Super Admin',
            'code'=>'sua',
            'description'=>'Super Admin Type'
            ]);
        
        DB::table('user_types')->insert([
        	'name'=>'Admin',
            'code'=>'adm',
            'description'=>'Admin'
        	]);  
        DB::table('user_types')->insert([
            'name'=>'User',
            'code'=>'usr',
            'description'=>'User'         
            ]);       

        //users
        DB::table('users')->insert([
            'agent_id'=>0,
        	'name'=>'Super Admin',
        	'login_name'=>'superadmin',            
        	'email'=>'superadmin@gmail.com',
        	'password'=>\Hash::make('abc123'), 
        	'nrc'=>'1/kakana(N)012121',
        	'user_type_id'=>1,
        	'phone'=>'454545455',
        	'credit'=>'200',
        	'api_key'=>'bm_project_app',
            'created_at'=> new DateTime(),
            'updated_at'=> new DateTime()
        	]);
         DB::table('users')->insert([
            'agent_id'=>0,
        	'name'=>'Admin',
        	'login_name'=>'admin',
        	'email'=>'admin@gmail.com',
        	'password'=>\Hash::make('abc123'), 
        	'nrc'=>'1/kakana(N)455445',
        	'user_type_id'=>2,
        	'phone'=>'454545455',
        	'credit'=>'200',
        	'api_key'=>\Hash::make('admin'),
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime()
        	]);
         DB::table('users')->insert([
            'agent_id'=>2,
        	'name'=>'User1',
        	'login_name'=>'user1',
        	'email'=>'user1@gmail.com',
        	'password'=>\Hash::make('abc123'), 
        	'nrc'=>'1/balaya(N)012121',
        	'user_type_id'=>3,
        	'phone'=>'454545455',
        	'credit'=>'200',
        	'api_key'=>\Hash::make('user1'),
            'created_at'=>new DateTime(),
            'updated_at'=>new DateTime()
        	]);
         
          DB::update('update users set id = 0 where id = ?', [1]);
    }
}
