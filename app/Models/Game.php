<?php

namespace App\Models;

use App\Concerns\FormattedDuration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $fillable = [
        'user_id',
        'name',
        'slug',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(
            'slug',
            fn(Builder $query) => $query->orderBy('slug')
        );
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo|User
    {
        return $this->belongsTo(User::class);
    }

    public function levels(): HasMany|Level
    {
        return $this->hasMany(Level::class);
    }

    protected function firstLetter(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => strtoupper(
                str_replace(
                    ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
                    '#',
                    substr($attributes['slug'] ?? '', 0, 1),
                )
            ),
        );
    }
}
