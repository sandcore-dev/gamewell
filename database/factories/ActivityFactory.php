<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        return [
            'status_id' => Status::factory(),
            'started_at' => $this->faker->dateTime,
            'stopped_at' => function (array $attributes) {
                return (new Carbon($attributes['started_at']))
                    ->addHours($this->faker->numberBetween(1, 5));
            },
        ];
    }
}
