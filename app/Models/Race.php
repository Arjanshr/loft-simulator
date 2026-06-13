<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Race extends Model
{
    protected $fillable = [
        'title',
        'distance_km',
        'difficulty_tier',
        'entry_fee',
        'prize_pool',
        'race_type',
        'level_requirement',
    ];

    public function results(): HasMany
    {
        return $this->hasMany(RaceResult::class);
    }
}
