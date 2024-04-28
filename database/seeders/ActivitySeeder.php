<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Status;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Status::count()) {
            $this->callSilent(StatusSeeder::class);
        }

        $statuses = Status::all();

        Activity::factory()
            ->times(100)
            ->create(
                [
                    'status_id' => function () use ($statuses) {
                        return $statuses->random();
                    },
                ]
            );
    }
}
