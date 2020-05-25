<?php

use App\Game;
use App\User;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!User::count()) {
            $this->callSilent(UserSeeder::class);
        }

        $users = User::all();

        foreach ($users as $user) {
            factory(Game::class, rand(3, 10))->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
