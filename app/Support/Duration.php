<?php

namespace App\Support;

use App\Models\Activity;
use Illuminate\Support\Carbon;

class Duration
{
    public static function update(Activity $activity, bool $force = false): void
    {
        if (
            $activity->stopped_at === null
            || (
                $activity->isClean(['started_at', 'stopped_at'])
                && !$force
            )
        ) {
            return;
        }

        $duration = $activity->stopped_at->diffInSeconds($activity->started_at, true);

        $orgStartedAt = $activity->getOriginal('started_at');
        $orgStoppedAt = $activity->getOriginal('stopped_at');

        if ($orgStoppedAt instanceof Carbon) {
            $duration -= $orgStoppedAt->diffInSeconds($orgStartedAt);
        }

        $activity->status->increment('duration', $duration);
        $activity->status->level->increment('duration', $duration);
        $activity->status->level->game->increment('duration', $duration);
    }

    public static function subtract(Activity $activity): void
    {
        if ($activity->stopped_at === null) {
            return;
        }

        $duration = $activity->stopped_at->diffInSeconds($activity->started_at);

        $activity->status->decrement('duration', $duration);
        $activity->status->level->decrement('duration', $duration);
        $activity->status->level->game->decrement('duration', $duration);
    }
}
