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
        'tokens',
        'level',
        'xp',
    ];

    protected $appends = ['total_passive_income', 'total_vitamin_income', 'total_token_income', 'capacity'];

    public function getTotalPassiveIncomeAttribute(): float
    {
        return $this->pigeons()->where('type', 'fancy')->where('status', '!=', 'chick')->get()->map(function($p) {
            $chance = 10 + ($p->beauty / 2);
            $income = 1 + (int)($p->beauty / 20);
            return ($chance / 100) * $income;
        })->sum();
    }

    public function getCapacityAttribute(): int
    {
        return 10 + ($this->level * 2);
    }

    public function getTotalVitaminIncomeAttribute(): float
    {
        return $this->pigeons()->where('type', 'highflyer')->where('status', '!=', 'chick')->get()->map(function($p) {
            $chance = 5 + ($p->speed / 5);
            return ($chance / 100) * 1;
        })->sum();
    }

    public function getTotalTokenIncomeAttribute(): float
    {
        return $this->pigeons()->where('type', 'racer')->where('status', '!=', 'chick')->get()->map(function($p) {
            $chance = 5 + ($p->speed / 5);
            return ($chance / 100) * 1;
        })->sum();
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
