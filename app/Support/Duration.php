<?php

namespace App\Support;

use App\Models\Activity;
use App\Models\Game;
use App\Models\Level;
use App\Models\Status;
use Illuminate\Support\Carbon;

class Duration
{
    public static function reset(Game $game): void
    {
        $game->duration = 0;
        $game->save();

        $game->levels()->update(['duration' => 0]);
        $game->levels->each(function (Level $level) {
            $level->statuses()->update(['duration' => 0]);
        });
    }

    public static function recalculate(Game $game): void
    {
        self::reset($game);

        $game->levels->each(function (Level $level) {
            $level->statuses->each(function (Status $status) {
                $status->activities->each(function (Activity $activity) {
                    self::update(
                        activity: $activity,
                        force:    true
                    );
                });
            });
        });
    }

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

        if ($activity->isDirty(['started_at', 'stopped_at'])) {
            $orgStartedAt = $activity->getOriginal('started_at');
            $orgStoppedAt = $activity->getOriginal('stopped_at');

            if ($orgStoppedAt instanceof Carbon) {
                $duration -= $orgStoppedAt->diffInSeconds($orgStartedAt, true);
            }
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
