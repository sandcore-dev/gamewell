<?php

use App\Duration;
use App\Status;
use Illuminate\Database\Seeder;

class DurationSeeder extends Seeder
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
            factory(Duration::class, rand(3, 15))->create([
                'status_id' => $status->id,
            ]);
        }
    }
}
