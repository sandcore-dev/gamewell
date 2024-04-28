<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        if (!Level::count()) {
            $this->callSilent(LevelSeeder::class);
        }

        $levels = Level::all();

        Status::factory()
            ->times(255)
            ->create(
                [
                    'level_id' => function () use ($levels) {
                        return $levels->random();
                    },
                ]
            );
    }
}
