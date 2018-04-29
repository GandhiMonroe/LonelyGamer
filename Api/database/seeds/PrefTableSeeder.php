<?php

use Illuminate\Database\Seeder;

class PrefTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('preferences')->insert([
            'userID' => 1,
            'gameID' => 1,
            'account' => 'FNC Caps1',
            'myPrimary' => 4,
            'mySecondary' => 3,
            'matchPrimary' => 5,
            'matchSecondary' => 1
        ]);
    
        \DB::table('preferences')->insert([
            'userID' => 2,
            'gameID' => 1,
            'account' => 'EunJongSeop',
            'myPrimary' => 5,
            'mySecondary' => 4,
            'matchPrimary' => 4,
            'matchSecondary' => 2
        ]);
    
        \DB::table('preferences')->insert([
            'userID' => 3,
            'gameID' => 1,
            'account' => 'ScarletRedHands',
            'myPrimary' => 3,
            'mySecondary' => 1,
            'matchPrimary' => 2,
            'matchSecondary' => 1
        ]);
    }
}
