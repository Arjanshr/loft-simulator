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
        'vitamins',
        'level',
        'xp',
    ];

    protected $appends = ['total_passive_income', 'total_vitamin_income'];

    public function getTotalPassiveIncomeAttribute(): float
    {
        return $this->pigeons()->where('type', 'fancy')->where('status', '!=', 'chick')->get()->sum('income_per_minute');
    }

    public function getTotalVitaminIncomeAttribute(): float
    {
        return $this->pigeons()->where('type', 'highflyer')->where('status', '!=', 'chick')->get()->sum('vitamin_income_per_minute');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pigeons(): HasMany
    {
        return $this->hasMany(Pigeon::class);
    }

    public function pairs(): HasMany
    {
        return $this->hasMany(Pair::class);
    }

    public function raceHistories(): HasMany
    {
        return $this->hasMany(RaceHistory::class);
    }

    public function breedingRecords(): HasMany
    {
        return $this->hasMany(BreedingRecord::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }
}
