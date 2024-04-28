<?php

namespace App\Models;

use App\Events\ActivityDeleted;
use App\Events\ActivitySaved;
use App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperActivity
 */
class Activity extends Model
{
    use HasFactory;

    const DATE_FORMAT = 'dddd, MMMM D, YYYY';
    const DATETIME_FORMAT = 'ddd DD MMM YYYY HH:mm:ss';
    const LUXON_DATETIME_FORMAT = 'ccc dd MMM yyyy HH:mm:ss';

    protected $fillable = [
        'status_id',
        'started_at',
        'stopped_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'stopped_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'saved' => ActivitySaved::class,
        'deleted' => ActivityDeleted::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('startedAt', function (Builder $query) {
            return $query->orderBy('started_at');
        });
    }

    public function status(): BelongsTo|Status
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

    public function scopeInProgress(Builder $query): Builder
    {
        return $query->whereNull('stopped_at');
    }

    public function getDateAttribute(): string
    {
        return $this->started_at->format('Y-m-d');
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->started_at->isoFormat(self::DATE_FORMAT);
    }

    public function getFormattedStartedAtAttribute(): string
    {
        return $this->started_at->isoFormat(self::DATETIME_FORMAT);
    }

    public function getFormattedStoppedAtAttribute(): string
    {
        return $this->stopped_at === null ? '' : $this->stopped_at->isoFormat(self::DATETIME_FORMAT);
    }

    public function getFormattedDurationAttribute(): string
    {
        return $this->stopped_at === null ? '' : $this->started_at->shortAbsoluteDiffForHumans($this->stopped_at, 3);
    }

    public function getLuxonDateTimeFormatAttribute(): string
    {
        return static::LUXON_DATETIME_FORMAT;
    }
}
