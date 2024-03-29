<?php

namespace App;

use App\Traits\FormattedDuration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Status
 *
 * @property int $id
 * @property int $level_id
 * @property int $attempt
 * @property string $status
 * @property int $duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Collection|\App\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read string $formatted_duration
 * @property-read \App\Activity|null $in_progress_activity
 * @property-read bool $in_progress
 * @property-read bool $is_ongoing
 * @property-read string $name
 * @property-read \App\Level $level
 * @method static \Illuminate\Database\Eloquent\Builder|Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Status query()
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereAttempt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Status whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Status extends Model
{
    use HasFactory;
    use FormattedDuration;

    public const ONGOING = 'ongoing';
    public const FINISHED = 'finished';
    public const DROPPED = 'dropped';

    protected $fillable = ['level_id', 'attempt', 'status'];

    protected $attributes = [
        'status' => self::ONGOING,
    ];

    /**
     * @return BelongsTo|Level
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * @return HasMany|Collection|Activity[]|Activity
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function getNameAttribute(): string
    {
        return __(':name - attempt :attempt', ['name' => $this->level->name, 'attempt' => $this->attempt]);
    }

    public function getIsOngoingAttribute(): bool
    {
        return $this->status === self::ONGOING;
    }

    public function getInProgressAttribute(): bool
    {
        return (bool)$this->activities()->inProgress()->count();
    }

    public function getInProgressActivityAttribute(): ?Activity
    {
        return $this->activities()->inProgress()->first();
    }
}
