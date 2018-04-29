<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      \DB::table('users')->insert([
          'name' => 'test',
          'email' => str_random(10).'@gmail.com',
          'password' => bcrypt('test'),
      ]);
      
      \DB::table('users')->insert([
          'name' => 'test2',
          'email' => str_random(10).'gmail.com',
          'password' => bcrypt('test2'),
      ]);
      
      \DB::table('users')->insert([
          'name' => 'test3',
          'email' => str_random(10).'gmail.com',
          'password' => bcrypt('test3'),
      ]);
    }
}