<?php

namespace App;

use App\Traits\FormattedDuration;
use Illuminate\Database\Eloquent\Collection;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activities
 * @property-read int|null $activities_count
 * @property-read \App\Level $level
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereAttempt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereUpdatedAt($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class Status extends Model
{
    use FormattedDuration;

    protected $fillable = ['level_id', 'attempt', 'status'];

    /**
     * @return BelongsTo|Level
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * @return HasMany|Collection|Activity[]
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function getNameAttribute(): string
    {
        return __(':name - attempt :attempt', ['name' => $this->level->name, 'attempt' => $this->attempt]);
    }
}
