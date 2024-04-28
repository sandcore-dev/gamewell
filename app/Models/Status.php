<?php

namespace App\Models;

use App\Concerns\FormattedDuration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperStatus
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
