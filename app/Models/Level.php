<?php

namespace App\Models;

use App\Concerns\FormattedDuration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperLevel
 */
class Level extends Model
{
    use HasFactory;
    use FormattedDuration;

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
