<?php

namespace Database\Factories;

use App\Game;
use App\Level;
use Illuminate\Database\Eloquent\Factories\Factory;

class LevelFactory extends Factory
{
    protected $model = Level::class;

    public function definition(): array
    {
        return [
            'game_id' => Game::factory(),
            'name' => $this->faker->unique()->catchPhrase,
            'order' => $this->faker->numberBetween(0, 255),
        ];
    }
}
