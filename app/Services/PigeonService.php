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
        $cost = config('game.training.rest_cost', 50);

        if ($pigeon->loft->vitamins < $cost || $pigeon->energy >= 100) {
            return false;
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($pigeon, $cost) {
            $pigeon->loft->decrement('vitamins', $cost);
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

        // Exponential cost calculation: base cost * (exponent ^ level)
        $baseCost = config('game.aesthetics.base_cost', 50);
        $exponent = config('game.aesthetics.cost_exponent', 1.15);
        $cost = (int) ($baseCost * pow($exponent, $currentValue));

        if ($pigeon->loft->coins < $cost) {
            return false;
        }

        $maxValue = config('game.aesthetics.max_value', 100);
        if ($currentValue >= $maxValue) {
            return false;
        }

        // Fractional growth: 0.5 to 1.0
        $gain = rand(5, 10) / 10;

        \Illuminate\Support\Facades\DB::transaction(function () use ($pigeon, $attribute, $cost, $gain, $maxValue) {
            $pigeon->loft->decrement('coins', $cost);
            $pigeon->update([
                $attribute => min($maxValue, $pigeon->{$attribute} + $gain),
            ]);
        });

        return true;
    }

    public function createAdult(Loft $loft, string $name, string $gender): Pigeon
    {
        $intelligence = Pigeon::rollCreationIntelligence();

        return Pigeon::create([
            'loft_id' => $loft->id,
            'name' => $name,
            'level' => 1,
            'type' => 'fancy',
            'gender' => $gender,
            'birth_at' => now()->subDays(10), // Adult
            'hatch_at' => now()->subDays(6),
            'eyes' => rand(1,10), 'beak' => rand(1,10), 'legs' => rand(1,10), 'feather_quality' => rand(1,10), 'pattern' => rand(1,10), 'color' => rand(1,10), 'purity' => rand(1,10),
            'speed' => rand(1,10), 'endurance' => rand(1,10), 'navigation' => rand(1,10), 'temperament' => rand(1,10),
            'energy' => 100, 'status' => 'idle',
            'loyalty' => 100,
            'intelligence' => $intelligence,
        ]);
    }

    public function createJuvenile(Loft $loft, string $name): Pigeon
    {
        $intelligence = Pigeon::rollCreationIntelligence();

        return Pigeon::create([
            'loft_id' => $loft->id,
            'name' => $name,
            'level' => 1,
            'type' => 'fancy',
            'gender' => fake()->randomElement(['male', 'female']),
            'birth_at' => now()->subDays(2), // Juvenile
            'hatch_at' => now()->subDays(1),
            'eyes' => rand(1,10), 'beak' => rand(1,10), 'legs' => rand(1,10), 'feather_quality' => rand(1,10), 'pattern' => rand(1,10), 'color' => rand(1,10), 'purity' => rand(1,10),
            'speed' => rand(1,10), 'endurance' => rand(1,10), 'navigation' => rand(1,10), 'temperament' => rand(1,10),
            'energy' => 100, 'status' => 'idle',
            'loyalty' => 100,
            'intelligence' => $intelligence,
        ]);
    }

    public function train(Pigeon $pigeon, string $stat): bool
    {
        $validStats = ['speed', 'endurance', 'navigation', 'temperament'];
        
        if (!in_array($stat, $validStats)) {
            return false;
        }

        // Logic constraint: Pigeon level can't exceed Loft level
        // Pigeon can only have max X points per level
        $multiplier = $pigeon->stat_limit_multiplier;
        if ($pigeon->{$stat} >= ($pigeon->level * $multiplier)) {
            return false;
        }

        $energyCost = config('game.training.energy_cost', 20);
        if ($pigeon->energy < $energyCost) {
            return false;
        }

        // 5 minute cooldown for training
        if ($pigeon->last_trained_at && $pigeon->last_trained_at->gt(now()->subMinutes(5))) {
            return false;
        }

        $gain = rand(1, 3);
        
        $pigeon->update([
            $stat => min($pigeon->level * $multiplier, $pigeon->{$stat} + $gain),
            'energy' => max(0, $pigeon->energy - $energyCost),
            'last_trained_at' => now(),
        ]);

        (new ActivityService())->log($pigeon->loft, "Trained {$pigeon->name}'s {$stat}.");

        return true;
    }
public function levelUpPigeon(Pigeon $pigeon): bool
{
    $maxLevel = config('game.pigeons.max_level', 100);
    if ($pigeon->level >= $maxLevel) {
        return false;
    }

    // Constraint: Pigeon level cannot exceed Loft level
    if ($pigeon->level >= $pigeon->loft->level) {
        return false;
    }

    // Milestone: Total stat points must be at least required stats to advance
    $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
    $requiredStats = $pigeon->required_stats;

    if ($totalStats < $requiredStats) {
        return false;
    }

    $rewardBase = config('game.pigeons.level_up_reward_base', 100);
    $xpReward = $pigeon->level * 10; // Reduced to 10 XP per level to balance Loft progression

    \Illuminate\Support\Facades\DB::transaction(function () use ($pigeon, $rewardBase, $xpReward) {
        $pigeon->increment('level');
        $pigeon->loft->increment('coins', $rewardBase * $pigeon->level);
        $pigeon->loft->increment('xp', $xpReward);
        (new ActivityService())->log($pigeon->loft, "{$pigeon->name} reached Level {$pigeon->level}! Earned {$xpReward} XP for the Loft.");
    });

    return true;
}

public function createStarter(Loft $loft, string $name): Pigeon
{
    $intelligence = Pigeon::rollCreationIntelligence();

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
        'speed' => rand(1, 5),
        'endurance' => rand(1, 5),
        'navigation' => rand(1, 5),
        'temperament' => rand(1, 5),
        'energy' => 100,
        'status' => 'idle',
        'loyalty' => 100,
        'intelligence' => $intelligence,
    ]);
}
}
