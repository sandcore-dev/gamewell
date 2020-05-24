<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Duration extends Model
{
    protected $fillable = ['status_id', 'started_at', 'stopped_at'];

    protected $dates = ['started_at', 'stopped_at'];

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
