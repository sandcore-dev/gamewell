<?php

namespace App\Listeners;

use App\Events\ActivityDeleted;
use App\Support\Duration;

class StatusSubtractDuration
{
    public function handle(ActivityDeleted $event): void
    {
        Duration::subtract($event->activity);
    }
}
