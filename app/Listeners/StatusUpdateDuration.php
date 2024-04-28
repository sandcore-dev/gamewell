<?php

namespace App\Listeners;

use App\Events\ActivitySaved;
use App\Support\Duration;
use Illuminate\Support\Carbon;

class StatusUpdateDuration
{
    public function handle(ActivitySaved $event): void
    {
        Duration::update($event->activity);
    }
}
