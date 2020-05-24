<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
    protected $fillable = ['level_id', 'attempt', 'status'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function durations(): HasMany
    {
        return $this->hasMany(Duration::class);
    }
}
