<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->create(['email' => 'webmaster@localhost']);

        User::factory()
            ->times(2)
            ->create();
    }
}
