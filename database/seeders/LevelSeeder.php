<?php

namespace Database\Seeders;

use App\Game;
use App\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Game::count()) {
            $this->callSilent(GameSeeder::class);
        }

        $games = Game::all();

        Level::factory()
            ->times($games->count() * 3)
            ->create(
                [
                    'game_id' => function () use ($games) {
                        return $games->random();
                    },
                ]
            );
    }
}
