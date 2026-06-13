<?php

namespace App\Services;

use App\Models\Pigeon;
use App\Models\Loft;
use App\Services\ActivityService;
use Carbon\Carbon;

class PigeonService
{
    public function instantRest(Pigeon $pigeon): bool
    {
        $cost = 50;

        if ($pigeon->loft->coins < $cost || $pigeon->energy >= 100) {
            return false;
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($pigeon, $cost) {
            $pigeon->loft->decrement('coins', $cost);
            $pigeon->update(['energy' => 100]);
        });

        return true;
    }

    public function improveAesthetics(Pigeon $pigeon, string $attribute): bool
    {
        $aestheticAttributes = ['feather_quality', 'pattern', 'color'];
        
        if (!in_array($attribute, $aestheticAttributes)) {
            return false;
        }

        // Current level of the attribute
        $currentValue = $pigeon->{$attribute};

        // Exponential cost calculation: base cost * (1.1 ^ level)
        // Ensure we handle rounding to int
        $cost = (int) (50 * pow(1.15, $currentValue));

        if ($pigeon->loft->coins < $cost) {
            return false;
        }

        if ($currentValue >= 100) {
            return false;
        }

        // Fractional growth: 0.5 to 1.0
        $gain = rand(5, 10) / 10;

        \Illuminate\Support\Facades\DB::transaction(function () use ($pigeon, $attribute, $cost, $gain) {
            $pigeon->loft->decrement('coins', $cost);
            $pigeon->update([
                $attribute => min(100, $pigeon->{$attribute} + $gain),
            ]);
        });

        return true;
    }

    public function train(Pigeon $pigeon, string $stat): bool
    {
        $validStats = ['speed', 'endurance', 'navigation', 'temperament'];
        
        if (!in_array($stat, $validStats)) {
            return false;
        }

        // Logic constraint: Pigeon level can't exceed Loft level
        // Pigeon can only have max 10 points per level
        if ($pigeon->{$stat} >= ($pigeon->level * 10)) {
            return false;
        }

        if ($pigeon->energy < 20) {
            return false;
        }

        // 5 minute cooldown for training
        if ($pigeon->last_trained_at && $pigeon->last_trained_at->gt(now()->subMinutes(5))) {
            return false;
        }

        $gain = rand(1, 3);
        
        $pigeon->update([
            $stat => min($pigeon->level * 10, $pigeon->{$stat} + $gain),
            'energy' => max(0, $pigeon->energy - 20),
            'last_trained_at' => now(),
        ]);

        (new ActivityService())->log($pigeon->loft, "Trained {$pigeon->name}'s {$stat}.");

        return true;
    }
public function levelUpPigeon(Pigeon $pigeon): bool
{
    if ($pigeon->level >= 100) {
        return false;
    }

    // Milestone: Total stat points must be at least level * 30 to advance
    $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
    $requiredStats = $pigeon->level * 30;

    if ($totalStats < $requiredStats) {
        return false;
    }

    \Illuminate\Support\Facades\DB::transaction(function () use ($pigeon) {
        $pigeon->increment('level');
        $pigeon->loft->increment('coins', 100 * $pigeon->level);
        (new ActivityService())->log($pigeon->loft, "{$pigeon->name} reached Level {$pigeon->level}!");
    });

    return true;
}

public function createStarter(Loft $loft, string $name): Pigeon
{
    return Pigeon::create([
        'loft_id' => $loft->id,
        'name' => $name,
        'level' => 1,
        'type' => 'fancy',
        'eyes' => rand(1, 5),
        'beak' => rand(1, 5),
        'legs' => rand(1, 5),
        'feather_quality' => rand(1, 5),
        'pattern' => rand(1, 5),
        'color' => rand(1, 5),
        'purity' => rand(1, 5),
        'rarity' => 'common',
        'speed' => rand(1, 5),
        'endurance' => rand(1, 5),
        'navigation' => rand(1, 5),
        'temperament' => rand(1, 5),
        'energy' => 100,
        'status' => 'idle',
    ]);
}
}
