<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pigeon extends Model
{
    use HasFactory;

    protected $fillable = [
        'loft_id',
        'name',
        'level',
        'type',
        'gender',
        'sire_id',
        'dam_id',
        'birth_at',
        'hatch_at',
        'eyes',
        'beak',
        'legs',
        'feather_quality',
        'pattern',
        'color',
        'purity',
        'rarity',
        'speed',
        'endurance',
        'navigation',
        'temperament',
        'energy',
        'status',
        'last_trained_at',
        'loyalty',
        'intelligence',
        'stray_at_loft_id',
        'lost_at',
    ];

    protected $casts = [
        'last_trained_at' => 'datetime',
        'birth_at' => 'datetime',
        'hatch_at' => 'datetime',
        'lost_at' => 'datetime',
    ];

    /**
     * Get the average beauty score.
     */
    public function getBeautyAttribute(): float
    {
        $avg = ($this->eyes + $this->beak + $this->legs + $this->feather_quality + $this->pattern + $this->color + $this->purity) / 7;
        return round($avg, 2);
    }

    /**
     * Get the pigeon's total score based on stats.
     */
    public function getTotalScoreAttribute(): float
    {
        // Score = (Stats) + (Beauty * Multiplier)
        return $this->speed + $this->endurance + $this->navigation + $this->temperament + ($this->beauty * 2);
    }
protected $appends = ['beauty', 'total_score', 'stat_grades', 'income_per_minute', 'vitamin_income_per_minute', 'fixed_price'];

/**
 * Get the fixed market price for this pigeon.
 */
public function getFixedPriceAttribute(): int
{
    $rarityMultiplier = match(strtolower($this->rarity)) {
        'legendary' => 5.0,
        'rare' => 2.0,
        default => 1.0,
    };
    
    $basePrice = ($this->level * 200) + ($this->total_score * 5);
    return (int) round($basePrice * $rarityMultiplier);
}

/**
 * Get the income generated per minute by this pigeon.
 */
public function getIncomePerMinuteAttribute(): float
{
    if ($this->type !== 'fancy' || $this->status === 'chick') {
        return 0;
    }

    return round(1 + ($this->beauty / 10), 2);
}

/**
 * Get the vitamin income generated per minute by this pigeon.
 */
public function getVitaminIncomePerMinuteAttribute(): float
{
    if ($this->type !== 'highflyer' || $this->status === 'chick') {
        return 0;
    }

    return round(1 + ($this->speed / 20), 2);
}

/**
 * Get visual grades for all trainable stats.
...
     */
    public function getStatGradesAttribute(): array
    {
        $stats = ['speed', 'endurance', 'navigation', 'temperament', 'beauty'];
        $grades = [];

        foreach ($stats as $stat) {
            $value = $this->{$stat};
            $grades[$stat] = match (true) {
                $value >= 95 => 'S+',
                $value >= 90 => 'S',
                $value >= 80 => 'A',
                $value >= 65 => 'B',
                $value >= 45 => 'C',
                default => 'D',
            };
        }

        return $grades;
    }

    public function loft(): BelongsTo
    {
        return $this->belongsTo(Loft::class);
    }
}
