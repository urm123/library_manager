<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
			'role_id' => '1',
			'first_name' => 'Master',
			'last_name' => 'Admin',
			'telephone' => '011245685',
			'email' => 'admin@gmail.com',
			'password' => bcrypt('123456'),
		]); 

		DB::table('users')->insert([
			'role_id' => '2',
			'first_name' => 'History',
			'last_name' => 'Author',
			'telephone' => '011245122',
			'email' => 'author@gmail.com',
			'password' => bcrypt('123456'),
		]);

		DB::table('users')->insert([
			'role_id' => '3',
			'first_name' => 'Site',
			'last_name' => 'User',
			'telephone' => '0112784569',
			'email' => 'user@gmail.com',
			'password' => bcrypt('123456'),
		]);
    }
}
