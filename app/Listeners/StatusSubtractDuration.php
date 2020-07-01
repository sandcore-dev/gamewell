<?php

namespace App\Listeners;

use App\Events\ActivityDeleted;

class StatusSubtractDuration
{
    /**
     * Handle the event.
     *
     * @param ActivityDeleted $event
     * @return void
     */
    public function handle(ActivityDeleted $event): void
    {
        $activity = $event->activity;
        if ($activity->stopped_at === null) {
            return;
        }

        $duration = $activity->stopped_at->diffInSeconds($activity->started_at);

        $activity->status->decrement('duration', $duration);
        $activity->status->level->decrement('duration', $duration);
        $activity->status->level->game->decrement('duration', $duration);
    }
}
