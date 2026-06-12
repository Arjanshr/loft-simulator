<?php

namespace App\Services;

use App\Models\Pigeon;
use App\Models\Loft;
use Carbon\Carbon;

class PigeonService
{
    public function train(Pigeon $pigeon, string $stat): bool
    {
        $validStats = ['speed', 'endurance', 'navigation', 'temperament'];
        
        if (!in_array($stat, $validStats)) {
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
            $stat => min(100, $pigeon->{$stat} + $gain),
            'energy' => max(0, $pigeon->energy - 20),
            'last_trained_at' => now(),
        ]);

        return true;
    }

    public function createStarter(Loft $loft, string $name): Pigeon
    {
        return Pigeon::create([
            'loft_id' => $loft->id,
            'name' => $name,
            'speed' => rand(15, 25),
            'endurance' => rand(15, 25),
            'navigation' => rand(15, 25),
            'temperament' => rand(15, 25),
            'energy' => 100,
            'status' => 'idle',
        ]);
    }
}
