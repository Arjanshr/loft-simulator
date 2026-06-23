<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pigeon extends Model
{
    use HasFactory;

    public const RARITY_WEIGHTS = [
        'mythic' => 2,       // 0.02% on creation rolls
        'legendary' => 200,  // 2%
        'super_rare' => 1000, // 10%
        'rare' => 2500,      // 25%
    ];

    protected static function booted()
    {
        static::saving(function ($pigeon) {
            $pigeon->rarity = static::rarityFromIntelligence((int) $pigeon->intelligence);
        });
    }

    public static function rarityFromIntelligence(int $intelligence): string
    {
        return match (true) {
            $intelligence >= 95 => 'mythic',
            $intelligence >= 80 => 'legendary',
            $intelligence >= 65 => 'super_rare',
            $intelligence >= 50 => 'rare',
            default => 'common',
        };
    }

    public static function rollCreationIntelligence(): int
    {
        $roll = random_int(1, 10000);

        return match (true) {
            $roll <= self::RARITY_WEIGHTS['mythic'] => random_int(95, 100),
            $roll <= self::RARITY_WEIGHTS['mythic'] + self::RARITY_WEIGHTS['legendary'] => random_int(80, 94),
            $roll <= self::RARITY_WEIGHTS['mythic'] + self::RARITY_WEIGHTS['legendary'] + self::RARITY_WEIGHTS['super_rare'] => random_int(65, 79),
            $roll <= self::RARITY_WEIGHTS['mythic'] + self::RARITY_WEIGHTS['legendary'] + self::RARITY_WEIGHTS['super_rare'] + self::RARITY_WEIGHTS['rare'] => random_int(50, 64),
            default => random_int(1, 49),
        };
    }

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
     * Get required stats to level up.
     */
    public function getRequiredStatsAttribute(): int
    {
        $requiredMultiplier = min(38.0, 28.0 + $this->level * 0.2);
        return (int) ($this->level * $requiredMultiplier);
    }

    /**
     * Get the pigeon's total score based on stats.
     */
    public function getTotalScoreAttribute(): float
    {
        // Score = (Stats) + (Beauty * Multiplier)
        return $this->speed + $this->endurance + $this->navigation + $this->temperament + ($this->beauty * 2);
    }

    /**
     * Get the stat limit multiplier based on the pigeon's rarity.
     */
    public function getStatLimitMultiplierAttribute(): int
    {
        return match ($this->rarity) {
            'mythic' => 16,
            'legendary' => 14,
            'super_rare' => 12,
            'rare' => 11,
            default => 10,
        };
    }

    protected $appends = [
        'beauty',
        'total_score',
        'stat_grades',
        'income_per_minute',
        'vitamin_income_per_minute',
        'token_income_per_minute',
        'fixed_price',
        'required_stats',
        'stat_limit_multiplier',
    ];
    /**
     * Get the fixed market price for this pigeon.
     */
    public function getFixedPriceAttribute(): int
    {
        $rarityMultiplier = match (strtolower($this->rarity)) {
            'mythic' => 15.0,
            'legendary' => 7.0,
            'super_rare' => 3.5,
            'rare' => 1.8,
            default => 1.0,
        };

        $basePrice = ($this->level * 200) + ($this->total_score * 5);
        return (int) round($basePrice * $rarityMultiplier);
    }

    /**
     * Get visual grades for all trainable stats.
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

    /**
     * Get passive reward configuration for this pigeon.
     */
    public function passiveReward(): array
    {
        if ($this->status === 'chick') {
            return [
                'resource' => null,
                'chance' => 0,
                'amount' => 0,
                'expected' => 0,
            ];
        }

        return match ($this->type) {
            'fancy' => [
                'resource' => 'tokens',
                'chance' => 10 + ($this->beauty / 2),
                'amount' => 1 + intdiv((int) $this->beauty, 20),
                'expected' => (
                    (10 + ($this->beauty / 2)) / 100
                ) * (1 + intdiv((int) $this->beauty, 20)),
            ],

            'highflyer' => [
                'resource' => 'vitamins',
                'chance' => 5 + ($this->speed / 5),
                'amount' => 1,
                'expected' => (5 + ($this->speed / 5)) / 100,
            ],

            'racer' => [
                'resource' => 'coins',
                'chance' => 5 + ($this->speed / 5),
                'amount' => 1,
                'expected' => (5 + ($this->speed / 5)) / 100,
            ],

            default => [
                'resource' => null,
                'chance' => 0,
                'amount' => 0,
                'expected' => 0,
            ],
        };
    }

    /**
     * Get the coin income generated per minute.
     */
    public function getIncomePerMinuteAttribute(): float
    {
        $reward = $this->passiveReward();

        return $reward['resource'] === 'coins'
            ? round($reward['expected'], 2)
            : 0;
    }

    /**
     * Get the vitamin income generated per minute.
     */
    public function getVitaminIncomePerMinuteAttribute(): float
    {
        $reward = $this->passiveReward();

        return $reward['resource'] === 'vitamins'
            ? round($reward['expected'], 2)
            : 0;
    }

    /**
     * Get the token income generated per minute.
     */
    public function getTokenIncomePerMinuteAttribute(): float
    {
        $reward = $this->passiveReward();

        return $reward['resource'] === 'tokens'
            ? round($reward['expected'], 2)
            : 0;
    }
}
