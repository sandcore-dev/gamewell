<?php

namespace Database\Factories;

use App\Level;
use App\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{
    protected $model = Status::class;

    public function definition(): array
    {
        return [
            'level_id' => Level::factory(),
            'attempt' => $this->faker->unique()->numberBetween(1, 255),
            'status' => $this->faker->randomElement(['ongoing', 'finished', 'dropped']),
        ];
    }
}
