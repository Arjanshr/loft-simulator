<?php

namespace App\Services;

use App\Models\Race;
use App\Models\Pigeon;
use App\Models\RaceResult;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RaceSimulationService
{
    /**
     * Simulate a race for a collection of pigeons.
     *
     * @param Race $race
     * @param Collection<Pigeon> $pigeons
     * @return Collection
     */
    public function simulate(Race $race, Collection $pigeons): Collection
    {
        $segments = 10;
        $segmentDistance = $race->distance_km / $segments;
        
        $results = $pigeons->map(function (Pigeon $pigeon) use ($segments, $segmentDistance) {
            $totalTime = 0;
            
            for ($i = 0; $i < $segments; $i++) {
                $totalTime += $this->calculateSegmentTime($pigeon, $segmentDistance, $i / $segments);
            }
            
            return [
                'pigeon' => $pigeon,
                'total_time' => $totalTime,
            ];
        });

        $sortedResults = $results->sortBy('total_time')->values();

        return DB::transaction(function () use ($race, $sortedResults) {
            return $sortedResults->map(function ($result, $index) use ($race) {
                $position = $index + 1;
                $payout = $this->calculatePayout($race, $position);
                
                $raceResult = RaceResult::create([
                    'race_id' => $race->id,
                    'pigeon_id' => $result['pigeon']->id,
                    'finish_time_seconds' => (int) $result['total_time'],
                    'position' => $position,
                    'payout' => $payout,
                ]);

                // Update pigeon status
                $result['pigeon']->update(['status' => 'idle']);
                
                // If payout > 0, update loft coins
                if ($payout > 0) {
                    $result['pigeon']->loft->increment('coins', $payout);
                }

                return $raceResult;
            });
        });
    }

    private function calculateSegmentTime(Pigeon $pigeon, float $distance, float $progress): float
    {
        // Base speed: 40 km/h to 100 km/h based on speed stat (10-100)
        $baseSpeedKmh = 40 + ($pigeon->speed * 0.6);
        
        // Endurance factor: as progress increases, speed might drop
        // Fatigue penalty is higher if endurance is low
        $fatigue = max(0, ($progress - 0.5) * (110 - $pigeon->endurance) * 0.05);
        $currentSpeed = max(20, $baseSpeedKmh - $fatigue);
        
        // Navigation: randomness factor
        // High navigation reduces the variance of the random penalty
        $randomPenalty = rand(0, (int)(110 - $pigeon->navigation)) / 100;
        $finalSpeed = $currentSpeed * (1 - $randomPenalty);
        
        // Temperament: minor daily/momentary boost or penalty
        $temperamentFactor = 0.95 + (($pigeon->temperament / 100) * 0.1); // 0.95 to 1.05
        $finalSpeed *= $temperamentFactor;

        // time = distance / speed
        // distance in km, speed in km/h, result in hours -> seconds
        return ($distance / $finalSpeed) * 3600;
    }

    private function calculatePayout(Race $race, int $position): int
    {
        if ($position === 1) return (int) ($race->prize_pool * 0.6);
        if ($position === 2) return (int) ($race->prize_pool * 0.25);
        if ($position === 3) return (int) ($race->prize_pool * 0.1);
        
        return 0;
    }
}
