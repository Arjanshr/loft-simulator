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
        // Use race level_requirement as tier stat ceiling (mythic multiplier 16 = highest possible)
        // Pigeons with stats beyond this cap get no extra advantage — randomness dominates
        $tierMaxStat = $race->level_requirement * 16;

        // Highflyer: endurance-based duration (longest flight wins)
        if ($race->race_type === 'highflyer') {
            $results = $pigeons->map(function (Pigeon $pigeon) use ($tierMaxStat) {
                // Normalize endurance against tier ceiling
                $enduranceRatio = min(1, $pigeon->endurance / max(1, $tierMaxStat));
                // 3600s base + up to 54000s (max ~16hrs at full endurance)
                $seconds = (int) (3600 + ($enduranceRatio * 54000));
                // Temperament drives variance: low ratio = unpredictable, high ratio = consistent
                $temperamentRatio = min(1, $pigeon->temperament / max(1, $tierMaxStat));
                $maxVariance = (int) ((1 - $temperamentRatio) * 50); // 0-50%
                $variance = rand(0, max(1, $maxVariance)) / 100;
                $seconds = (int) ($seconds * (1 - $variance));
                return [
                    'pigeon' => $pigeon,
                    'total_time' => $seconds,
                ];
            });
            // Descending: longest flight = 1st place
            $sortedResults = $results->sortByDesc('total_time')->values();
        } else {
            $segments = 10;
            $segmentDistance = $race->distance_km / $segments;

            $results = $pigeons->map(function (Pigeon $pigeon) use ($segments, $segmentDistance, $race, $tierMaxStat) {
                $totalTime = 0;

                for ($i = 0; $i < $segments; $i++) {
                    $totalTime += $this->calculateSegmentTime($pigeon, $segmentDistance, $i / $segments, $race->race_type, $tierMaxStat);
                }

                return [
                    'pigeon' => $pigeon,
                    'total_time' => $totalTime,
                ];
            });

            $sortedResults = $results->sortBy('total_time')->values();
        }

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
                if($pigeon->loft->level < 5) {
                    $pigeon->loft->increment('xp', 3 * $xpAwarded);
                }else{
                    $pigeon->loft->increment('xp', $xpAwarded);
                }

                // Update pigeon status
                $pigeon->update(['status' => 'idle']);
                
                // If payout > 0, update loft currency based on race type
                if ($payout > 0) {
                    if ($race->race_type === 'exhibition') {
                        $pigeon->loft->increment('tokens', $payout);
                    } elseif ($race->race_type === 'highflyer') {
                        $pigeon->loft->increment('vitamins', $payout);
                    } else {
                        $pigeon->loft->increment('coins', $payout);
                    }
                }

                return $raceResult;
            });
        });
    }

    private function calculateSegmentTime(Pigeon $pigeon, float $distance, float $progress, string $raceType, int $tierMaxStat): float
    {
        // Calculate base speed based on race type requirements
        switch ($raceType) {
            case 'exhibition':
                // Pure beauty contest — score is inversely proportional to beauty
                // Higher beauty → lower "time" → better rank. No speed, no distance.
                $score = $pigeon->beauty * (1 - (rand(0, 5) / 100)); // tiny variance to avoid ties
                return 1000 / max(1, $score);

            case 'racing':
            default:
                // Normalize stats against tier ceiling — over-leveled pigeons gain no extra edge
                $speedRatio = min(1, $pigeon->speed / max(1, $tierMaxStat));
                $enduranceRatio = min(1, $pigeon->endurance / max(1, $tierMaxStat));
                $navRatio = min(1, $pigeon->navigation / max(1, $tierMaxStat));
                $temperamentRatio = min(1, $pigeon->temperament / max(1, $tierMaxStat));

                // Base speed: 40-100 km/h scaled by speed + endurance
                $baseSpeedKmh = 40 + ($speedRatio * 40) + ($enduranceRatio * 20);

                // Fatigue: low endurance ratio = more fatigue in later segments
                $fatigue = max(0, ($progress - 0.5) * (1 - $enduranceRatio) * 5);
                $currentSpeed = max(20, $baseSpeedKmh - $fatigue);

                // Navigation penalty: low nav = can get lost for hours
                // Max 30 min lost per segment at nav=0, ~0 min at nav=1.0
                $maxLostMinutes = (int) ((1 - $navRatio) * 30);
                $lostTimeSeconds = rand(0, max(1, $maxLostMinutes)) * 60;

                // Temperament: 0.95-1.05 scaled by ratio (consistency factor)
                $temperamentFactor = 0.95 + ($temperamentRatio * 0.1);
                $finalSpeed = max(1, $currentSpeed * $temperamentFactor);

                // Segment time = flight time + potential lost time from bad navigation
                return ($distance / $finalSpeed) * 3600 + $lostTimeSeconds;
        }
    }

    private function calculatePayout(Race $race, int $position): int
    {
        if ($position === 1) return (int) ($race->prize_pool * 0.6);
        if ($position === 2) return (int) ($race->prize_pool * 0.25);
        if ($position === 3) return (int) ($race->prize_pool * 0.1);
        
        return 0;
    }
}
