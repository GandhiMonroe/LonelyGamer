<?php

use Illuminate\Database\Seeder;

class MatchRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('match_request')->insert([
            'userID' => 2,
            'matchID' => 1,
            'gameID' => 1
        ]);
    
        \DB::table('match_request')->insert([
            'userID' => 3,
            'matchID' => 1,
            'gameID' => 1
        ]);
    }
}
