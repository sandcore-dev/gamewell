<?php

use App\Level;
use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Level::count()) {
            $this->callSilent(LevelSeeder::class);
        }

        $levels = Level::all();

        foreach ($levels as $level) {
            factory(Status::class, rand(1, 3))->create([
                'level_id' => $level->id,
            ]);
        }
    }
}
