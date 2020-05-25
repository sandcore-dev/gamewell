<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Game;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Game::class, function (Faker $faker, array $attributes) {
    $company = $faker->unique()->company;
    return [
        'user_id' => $attributes['user_id'] ?? factory(User::class)->create()->id,
        'name' => $company,
        'slug' => Str::slug($company),
    ];
});
