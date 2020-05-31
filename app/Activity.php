<?php

namespace App;

use App\Events\ActivitySaved;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity user(\App\User $user)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereStoppedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity yearWeek($year, $week)
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

    protected static function booted()
    {
        static::addGlobalScope('startedAt', function (Builder $query) {
            return $query->orderBy('started_at');
        });
    }

    /**
     * @return BelongsTo|Status
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function scopeUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('status.level.game', function (Builder $query) use ($user) {
            return $query->where('user_id', '=', $user->id);
        });
    }

    public function scopeYearWeek(Builder $query, int $year, int $week): Builder
    {
        $date = Carbon::now()->isoWeekYear($year)->isoWeek($week);
        return $query->whereBetween('started_at', [$date->startOfWeek(), $date->clone()->endOfWeek()]);
    }

    public function getDateAttribute(): string
    {
        return $this->started_at->format('Y-m-d');
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->started_at->isoFormat('dddd, MMMM D, YYYY');
    }

    public function getFormattedDurationAttribute(): string
    {
        return $this->started_at->shortAbsoluteDiffForHumans($this->stopped_at);
    }
}
