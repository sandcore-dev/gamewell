<?php

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

        foreach ($games as $game) {
            factory(Level::class, rand(1, 3))->create([
                'game_id' => $game->id,
            ]);
        }
    }
}
