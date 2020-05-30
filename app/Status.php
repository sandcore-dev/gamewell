<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int duration
 * @property BelongsTo|Level level
 * @property HasMany|Collection|Activity[] activities
 * @method static int count()
 */
class Status extends Model
{
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
}
