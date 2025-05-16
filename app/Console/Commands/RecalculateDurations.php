<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Support\Duration;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RecalculateDurations extends Command
{
    protected $signature = 'recalculate-durations
        {id-or-slug? : ID or slug from game}
        {--all : Recalculate durations for all games}
    ';

    protected $description = 'Recalculate durations for a game';

    public function handle(): int
    {
        if ($this->option('all')) {
            Game::eachById([Duration::class, 'recalculate']);
            return self::SUCCESS;
        }

        if (!$this->argument('id-or-slug')) {
            $this->error('No ID or slug provided');
            return self::INVALID;
        }

        try {
            $game = Game::query()
                ->where('id', $this->argument('id-or-slug'))
                ->orWhere('slug', $this->argument('id-or-slug'))
                ->firstOrFail();

            Duration::recalculate($game);
        } catch (ModelNotFoundException $e) {
            $this->error('Game not found');
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
