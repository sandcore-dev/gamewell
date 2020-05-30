<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property
 * @property BelongsTo|Game game
 * @property HasMany|Collection|Status[] statuses
 */
class Level extends Model
{
    protected $fillable = ['game_id', 'name', 'order'];

    /**
     * @return BelongsTo|Game
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * @return HasMany|Collection|Status[]
     */
    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class);
    }
}
