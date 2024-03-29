<?php

namespace App;

use App\Traits\FormattedDuration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Game
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $slug
 * @property int $duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $formatted_duration
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Level[] $levels
 * @property-read int|null $levels_count
 * @property-read \App\User $user
 * @method static Builder|Game newModelQuery()
 * @method static Builder|Game newQuery()
 * @method static Builder|Game query()
 * @method static Builder|Game whereCreatedAt($value)
 * @method static Builder|Game whereDuration($value)
 * @method static Builder|Game whereId($value)
 * @method static Builder|Game whereName($value)
 * @method static Builder|Game whereSlug($value)
 * @method static Builder|Game whereUpdatedAt($value)
 * @method static Builder|Game whereUserId($value)
 * @mixin \Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
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
