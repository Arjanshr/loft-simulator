<?php

namespace App\Services;

use App\Models\Race;
use App\Models\Pigeon;
use App\Models\RaceResult;
use App\Models\RaceHistory;
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
    public function simulate(Race $race, Collection $pigeons, array $playerPigeonIds = [], int $multiplier = 1): Collection
    {
        $segments = 10;
        $segmentDistance = $race->distance_km / $segments;
        
        $results = $pigeons->map(function (Pigeon $pigeon) use ($segments, $segmentDistance, $race) {
            $totalTime = 0;
            
            for ($i = 0; $i < $segments; $i++) {
                $totalTime += $this->calculateSegmentTime($pigeon, $segmentDistance, $i / $segments, $race->race_type);
            }
            
            return [
                'pigeon' => $pigeon,
                'total_time' => $totalTime,
            ];
        });

        $sortedResults = $results->sortBy('total_time')->values();

        return DB::transaction(function () use ($race, $sortedResults, $playerPigeonIds, $multiplier) {
            return $sortedResults->map(function ($result, $index) use ($race, $playerPigeonIds, $multiplier) {
                $pigeon = $result['pigeon'];
                $position = $index + 1;
                $payout = $this->calculatePayout($race, $position);
                
                if (in_array($pigeon->id, $playerPigeonIds)) {
                    $payout *= $multiplier;
                }
                
                $raceResult = RaceResult::create([
                    'race_id' => $race->id,
                    'pigeon_id' => $pigeon->id,
                    'finish_time_seconds' => (int) $result['total_time'],
                    'position' => $position,
                    'payout' => $payout,
                ]);

                // Log History
                RaceHistory::create([
                    'loft_id' => $pigeon->loft_id,
                    'race_title' => $race->title,
                    'race_type' => $race->race_type,
                    'pigeon_name' => $pigeon->name,
                    'position' => $position,
                    'payout' => $payout,
                ]);

                // Award XP to loft
                // Formula: Tier * (40 / Position)
                $xpAwarded = (int) ($race->difficulty_tier * (40 / $position));
                
                if (in_array($pigeon->id, $playerPigeonIds)) {
                    $xpAwarded *= $multiplier;
                }
                
                $pigeon->loft->increment('xp', $xpAwarded);

                // Update pigeon status
                $pigeon->update(['status' => 'idle']);
                
                // If payout > 0, update loft currency based on race type
                if ($payout > 0) {
                    if ($race->race_type === 'exhibition') {
                        $pigeon->loft->increment('vitamins', $payout);
                    } elseif ($race->race_type === 'highflyer') {
                        $pigeon->loft->increment('tokens', $payout);
                    } else {
                        $pigeon->loft->increment('coins', $payout);
                    }
                }

                return $raceResult;
            });
        });
    }

    private function calculateSegmentTime(Pigeon $pigeon, float $distance, float $progress, string $raceType): float
    {
        // Calculate base speed based on race type requirements
        switch ($raceType) {
            case 'exhibition':
                // Beauty focus
                $baseSpeedKmh = 40 + ($pigeon->beauty * 0.6);
                break;
            case 'highflyer':
                // Endurance + Navigation focus
                $baseSpeedKmh = 40 + (($pigeon->endurance + $pigeon->navigation) * 0.3);
                break;
            case 'racing':
            default:
                // Speed + Endurance focus
                $baseSpeedKmh = 40 + (($pigeon->speed * 0.4) + ($pigeon->endurance * 0.2));
                break;
        }
        
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

        // Ensure finalSpeed is not zero to avoid division by zero
        $finalSpeed = max(1, $finalSpeed);

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
