<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    protected $fillable = ['game_id', 'name', 'order'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function statuses(): HasMany
    {
        return $this->hasMany(Status::class);
    }
}
