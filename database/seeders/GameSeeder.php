<?php

namespace Database\Seeders;

use App\Game;
use App\User;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::count()) {
            $this->callSilent(UserSeeder::class);
        }

        $users = User::all();

        Game::factory()
            ->times($users->count() * 10)
            ->create(
                [
                    'user_id' => function () use ($users) {
                        return $users->random();
                    },
                ]
            );
    }
}
