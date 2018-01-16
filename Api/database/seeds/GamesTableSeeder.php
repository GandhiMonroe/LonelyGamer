<?php

use Illuminate\Database\Seeder;

class GamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('game')->truncate();
        \DB::table('game')->insert([
            'id' => 1,
            'name' => 'League of Legends',
            'created_at' => $date = date('Y-m-d H:i:s'),
            'updated_at' => $date = date('Y-m-d H:i:s')
        ]);
        \DB::table('game')->insert([
            'id' => 2,
            'name' => 'DOTA 2',
            'created_at' => $date = date('Y-m-d H:i:s'),
            'updated_at' => $date = date('Y-m-d H:i:s')
        ]);
    }
}
