<?php

namespace App;

use App\Events\ActivitySaved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property Carbon|null started_at
 * @property Carbon|null stopped_at
 * @property BelongsTo|Status status
 */
class Activity extends Model
{
    protected $fillable = ['status_id', 'started_at', 'stopped_at'];

    protected $dates = ['started_at', 'stopped_at'];

    protected $dispatchesEvents = [
        'saved' => ActivitySaved::class,
    ];

    /**
     * @return BelongsTo|Status
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
