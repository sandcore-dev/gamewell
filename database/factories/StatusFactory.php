<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Level;
use App\Status;
use Faker\Generator as Faker;

$factory->define(Status::class, function (Faker $faker, array $attributes) {
    return [
        'level_id' => $attributes['level_id'] ?? factory(Level::class)->create()->id,
        'attempt' => $faker->numberBetween(1, 255),
        'status' => $faker->randomElement(['ongoing', 'finished', 'dropped']),
    ];
});
