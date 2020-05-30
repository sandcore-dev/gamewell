<?php

namespace App;

use App\Events\ActivitySaved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Activity
 *
 * @property int $id
 * @property int $status_id
 * @property \Illuminate\Support\Carbon $started_at
 * @property \Illuminate\Support\Carbon|null $stopped_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Status $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereStoppedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
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
