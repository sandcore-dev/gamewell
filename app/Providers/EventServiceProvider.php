<?php

namespace App\Providers;

use App\Events\ActivityDeleted;
use App\Events\ActivitySaved;
use App\Listeners\StatusSubtractDuration;
use App\Listeners\StatusUpdateDuration;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ActivitySaved::class => [
            StatusUpdateDuration::class,
        ],
        ActivityDeleted::class => [
            StatusSubtractDuration::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
