<?php

namespace App\Models;

use App\Concerns\FormattedDuration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperGame
 */
class Game extends Model
{
    use HasFactory;
    use FormattedDuration;

    protected $fillable = ['user_id', 'name', 'slug'];

    protected static function booted()
    {
        static::addGlobalScope('slug', function (Builder $query) {
            return $query->orderBy('slug', 'ASC');
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function levels(): HasMany
    {
        return $this->hasMany(Level::class);
    }
}
