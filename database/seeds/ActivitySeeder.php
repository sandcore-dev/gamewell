<?php

use App\Activity;
use App\Status;
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

        foreach ($statuses as $status) {
            factory(Activity::class, rand(3, 15))->create([
                'status_id' => $status->id,
            ]);
        }
    }
}
