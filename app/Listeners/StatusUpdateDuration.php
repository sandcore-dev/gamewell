<?php

namespace App\Listeners;

use App\Events\ActivitySaved;
use Illuminate\Support\Carbon;

class StatusUpdateDuration
{
    /**
     * Handle the event.
     *
     * @param ActivitySaved $event
     * @return void
     */
    public function handle(ActivitySaved $event): void
    {
        $activity = $event->activity;
        if ($activity->isClean(['started_at', 'stopped_at']) || $activity->stopped_at === null) {
            return;
        }

        $duration = $activity->stopped_at->diffInSeconds($activity->started_at);

        $orgStartedAt = $activity->getOriginal('started_at');
        $orgStoppedAt = $activity->getOriginal('stopped_at');

        if ($orgStoppedAt instanceof Carbon) {
            $duration -= $orgStoppedAt->diffInSeconds($orgStartedAt);
        }

        $activity->status->increment('duration', $duration);
        $activity->status->level->increment('duration', $duration);
        $activity->status->level->game->increment('duration', $duration);
    }
}
