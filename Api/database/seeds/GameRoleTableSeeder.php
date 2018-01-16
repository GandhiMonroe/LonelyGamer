<?php

use Illuminate\Database\Seeder;

class GameRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('game_roles')->truncate();
        \DB::table('game_roles')->insert([
            'id' => 1,
            'game' => 1,
            'role' => 'Top',
            'created_at' => $date = date('Y-m-d H:i:s'),
            'updated_at' => $date = date('Y-m-d H:i:s')
        ]);
        \DB::table('game_roles')->insert([
            'id' => 2,
            'game' => 1,
            'role' => 'Jungle',
            'created_at' => $date = date('Y-m-d H:i:s'),
            'updated_at' => $date = date('Y-m-d H:i:s')
        ]);
        \DB::table('game_roles')->insert([
            'id' => 3,
            'game' => 1,
            'role' => 'Mid',
            'created_at' => $date = date('Y-m-d H:i:s'),
            'updated_at' => $date = date('Y-m-d H:i:s')
        ]);
        \DB::table('game_roles')->insert([
            'id' => 4,
            'game' => 1,
            'role' => 'ADC',
            'created_at' => $date = date('Y-m-d H:i:s'),
            'updated_at' => $date = date('Y-m-d H:i:s')
        ]);
        \DB::table('game_roles')->insert([
            'id' => 5,
            'game' => 1,
            'role' => 'Support',
            'created_at' => $date = date('Y-m-d H:i:s'),
            'updated_at' => $date = date('Y-m-d H:i:s')
        ]);
    }
}
