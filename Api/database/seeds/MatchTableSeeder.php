<?php

use Illuminate\Database\Seeder;

class MatchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('match')->insert([
            'userID' => 'WEF',
            'matchUserID' => 'Pat',
        ]);
        \DB::table('match')->insert([
            'userID' => 'WEF',
            'matchUserID' => 'Do you know da wei?',
        ]);
        \DB::table('match')->insert([
            'userID' => 'WEF',
            'matchUserID' => 'Fuck my asshole',
        ]);
    }
}
