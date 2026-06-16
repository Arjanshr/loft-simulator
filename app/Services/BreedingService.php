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

            $sire->update([
                'status' => 'incubating',
                'loyalty' => min(100, $sire->loyalty + 10),
            ]);
            $dam->update([
                'status' => 'incubating',
                'loyalty' => min(100, $dam->loyalty + 10),
            ]);
            (new ActivityService())->log($pair->loft, "Started incubation for pair: {$sire->name} ♂ + {$dam->name} ♀.");
        });

        return true;
    }

    public function hatchEgg(BreedingRecord $record)
    {
        $sire = $record->sire;
        $dam = $record->dam;
        $loft = $record->loft;

        if (!$sire || !$dam) {
            \Illuminate\Support\Facades\Log::error("Hatch failed: Sire or Dam missing for BreedingRecord {$record->id}");
            $record->delete();
            return;
        }

        // Produce 2 chicks
        for ($i = 0; $i < 2; $i++) {
            $stats = $this->calculateInheritedStats($sire, $dam);
            
            // Automatically determine level based on stats (30 points per level)
            $totalPoints = $stats['speed'] + $stats['endurance'] + $stats['navigation'] + $stats['temperament'];
            $initialLevel = max(1, (int)floor($totalPoints / 30));

            $chick = Pigeon::create(array_merge($stats, [
                'loft_id' => $loft->id,
                'name' => 'Chick ' . fake()->unique()->firstName(),
                'level' => $initialLevel,
                'type' => $sire->type, // Inherits type from Sire
                'gender' => fake()->randomElement(['male', 'female']),
                'sire_id' => $sire->id,
                'dam_id' => $dam->id,
                'birth_at' => now(),
                'hatch_at' => now(),
                'status' => 'chick',
            ]));

            (new ActivityService())->log($loft, "HATCHED: A Level {$chick->level} {$chick->type} chick named {$chick->name} has been born!");
        }

        $record->delete();
        $sire->update(['status' => 'nursing']);
        $dam->update(['status' => 'nursing']);
        (new ActivityService())->log($loft, "Pair {$sire->name} + {$dam->name} are now nursing their 2 new chicks.");
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
