<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loft extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'coins',
        'level',
        'xp',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pigeons(): HasMany
    {
        return $this->hasMany(Pigeon::class);
    }

    public function raceHistories(): HasMany
    {
        return $this->hasMany(RaceHistory::class);
    }
}
