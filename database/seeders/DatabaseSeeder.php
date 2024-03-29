<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(GameSeeder::class);
         $this->call(LevelSeeder::class);
         $this->call(StatusSeeder::class);
         $this->call(ActivitySeeder::class);
    }
}
