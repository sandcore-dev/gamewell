<?php

namespace App\Events;

use App\Activity;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Activity
     */
    public $activity;

    /**
     * Create a new event instance.
     *
     * @param Activity $activity
     */
    public function __construct(Activity $activity)
    {
        $this->activity = $activity->loadMissing(['status.level.game']);
    }
}
