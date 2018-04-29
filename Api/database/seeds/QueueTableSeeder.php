<?php

use Illuminate\Database\Seeder;

class QueueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('match_queue')->insert([
            'userID' => 2,
            'gameID' => 1,
            'rank' => 27,
            'tier' => 'CHALLENGER',
            'division' => 'I'
        ]);
    
        \DB::table('match_queue')->insert([
            'userID' => 3,
            'gameID' => 1,
            'rank' => 27,
            'tier' => 'CHALLENGER',
            'division' => 'I'
        ]);
    }
}
