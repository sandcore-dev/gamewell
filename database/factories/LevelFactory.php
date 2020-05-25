<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Game;
use App\Level;
use Faker\Generator as Faker;

$factory->define(Level::class, function (Faker $faker, array $attributes) {
    return [
        'game_id' => $attributes['game_id'] ?? factory(Game::class)->create()->id,
        'name' => $faker->unique()->catchPhrase,
        'order' => $faker->numberBetween(0, 255),
    ];
});
