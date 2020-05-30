<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Activity;
use App\Status;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker, array $attributes) {
    $startedAt = $faker->dateTime;
    return [
        'status_id' => $attributes['status_id'] ?? factory(Status::class)->create()->id,
        'started_at' => $startedAt,
        'stopped_at' => $faker->dateTimeInInterval($startedAt, '+5 hours'),
    ];
});
