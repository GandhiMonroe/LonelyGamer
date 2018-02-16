<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            GamesTableSeeder::class,
            GameRoleTableSeeder::class,
            MatchTableSeeder::class,
            PrefTableSeeder::class
        ]);
    }
}
