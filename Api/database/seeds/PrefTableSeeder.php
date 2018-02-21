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
            'account' => 'C9 Dilib',
            'myPrimary' => 1,
            'mySecondary' => 2,
            'matchPrimary' => 3,
            'matchSecondary' => 4
      ]);
    }
}
