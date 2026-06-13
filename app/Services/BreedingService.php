<?php

namespace App\Services;

use App\Models\Loft;
use App\Models\Pigeon;
use App\Models\Pair;
use App\Models\BreedingRecord;
use App\Services\ActivityService;
use App\Services\GameSettingsService;
use Illuminate\Support\Facades\DB;

class BreedingService
{
    public function breed(Pair $pair): bool
    {
        $sire = $pair->male;
        $dam = $pair->female;
        $settings = new GameSettingsService();
        $cost = (int) $settings->get('breeding_cost', 100);

        // 1. Constraints
        if ($sire->status !== 'idle' || $dam->status !== 'idle') {
            return false;
        }

        // Inbreeding check (simplified: no same parents)
        if ($sire->sire_id === $dam->sire_id && $sire->sire_id !== null) {
            return false;
        }

        // 2. Logic: Create Breeding Record (starts incubation)
        DB::transaction(function () use ($pair, $sire, $dam, $cost) {
            $pair->loft->decrement('coins', $cost); // Breeding cost
            
            BreedingRecord::create([
                'loft_id' => $pair->loft_id,
                'sire_id' => $sire->id,
                'dam_id' => $dam->id,
                'eggs_laid_at' => now(),
            ]);

            $sire->update(['status' => 'incubating']);
            $dam->update(['status' => 'incubating']);
            (new ActivityService())->log($pair->loft, "Started incubation for pair: {$sire->name} ♂ + {$dam->name} ♀.");
        });

        return true;
    }

    public function hatchEgg(BreedingRecord $record)
    {
        $sire = $record->sire;
        $dam = $record->dam;
        $loft = $record->loft;

        // Produce 2 chicks
        for ($i = 0; $i < 2; $i++) {
            $stats = $this->calculateInheritedStats($sire, $dam);
            
            Pigeon::create(array_merge($stats, [
                'loft_id' => $loft->id,
                'name' => 'Chick ' . fake()->unique()->firstName(),
                'level' => 1,
                'type' => $sire->type, // Simplified: inherits type from Sire
                'gender' => fake()->randomElement(['male', 'female']),
                'sire_id' => $sire->id,
                'dam_id' => $dam->id,
                'birth_at' => now(),
                'status' => 'egg',
            ]));
        }

        $record->delete();
        $sire->update(['status' => 'idle']);
        $dam->update(['status' => 'idle']);
        (new ActivityService())->log($loft, "Pair {$sire->name} + {$dam->name} successfully hatched 2 chicks.");
    }

    private function calculateInheritedStats(Pigeon $sire, Pigeon $dam): array
    {
        $attributes = ['eyes', 'beak', 'legs', 'feather_quality', 'pattern', 'color', 'purity', 'speed', 'endurance', 'navigation', 'temperament'];
        $inherited = [];

        foreach ($attributes as $attr) {
            // Inheritance: Average of parents + mutation (-5% to +5%)
            $avg = ($sire->{$attr} + $dam->{$attr}) / 2;
            $mutation = $avg * (rand(-5, 5) / 100);
            $inherited[$attr] = max(1, min(100, (int)($avg + $mutation)));
        }

        $inherited['rarity'] = $this->calculateRarity($sire, $dam);

        return $inherited;
    }

    private function calculateRarity(Pigeon $sire, Pigeon $dam): string
    {
        $rarities = ['common' => 1, 'rare' => 2, 'legendary' => 3];
        $avgRarity = ($rarities[$sire->rarity] + $rarities[$dam->rarity]) / 2;
        
        // Chance to upgrade
        if (rand(1, 100) <= 10) {
            $avgRarity += 0.5;
        }

        return match (true) {
            $avgRarity >= 2.5 => 'legendary',
            $avgRarity >= 1.5 => 'rare',
            default => 'common',
        };
    }
}
