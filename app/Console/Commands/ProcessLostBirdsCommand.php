<?php

namespace App\Console\Commands;

use App\Services\GameSettingsService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('pigeons:process-lost')]
#[Description('Process the movement and return of lost pigeons, and trigger new lost bird events.')]
class ProcessLostBirdsCommand extends Command
{
    public function handle(GameSettingsService $settingsService)
    {
        $birdsPerHumanPerHour = $settingsService->get('ai_lost_birds_per_human_per_hour', null);

        if ($birdsPerHumanPerHour === null) {
            $legacyChance = (float) $settingsService->get('ai_lost_bird_chance', 20);
            $birdsPerHumanPerHour = $legacyChance > 1 ? $legacyChance / 100 : $legacyChance;
        }

        $birdsPerHumanPerHour = (float) $birdsPerHumanPerHour;
        $birdsPerHumanPerHour = max(0, $birdsPerHumanPerHour);
        $humanPlayerCount = \App\Models\User::where('is_ai', false)->count();
        $expectedLosses = $humanPlayerCount * $birdsPerHumanPerHour;
        $lossCount = (int) floor($expectedLosses);

        if ((mt_rand() / mt_getrandmax()) < ($expectedLosses - $lossCount)) {
            $lossCount++;
        }

        if ($humanPlayerCount > 0 && $lossCount > 0) {
            // 1. Trigger new lost birds (AI Lofts)
            $eligiblePigeons = \App\Models\Pigeon::query()
                ->where('status', 'idle')
                ->where('loyalty', '<', 30)
                ->whereHas('loft', fn($q) => $q->whereHas('user', fn($userQuery) => $userQuery->where('is_ai', true)))
                ->with('loft')
                ->inRandomOrder()
                ->limit($lossCount)
                ->get();

            foreach ($eligiblePigeons as $pigeon) {
                $originLoft = $pigeon->loft;
                $randomLoft = \App\Models\Loft::where('id', '!=', $originLoft->id)->inRandomOrder()->first();

                if (! $randomLoft) {
                    continue;
                }

                $pigeon->update([
                    'status' => 'lost',
                    'lost_at' => now(),
                    'stray_at_loft_id' => $randomLoft->id,
                ]);

                \Illuminate\Support\Facades\Log::info(
                    "Process Lost Birds: AI pigeon {$pigeon->name} got lost from {$originLoft->name} at {$birdsPerHumanPerHour} birds/human/hour with {$humanPlayerCount} human players."
                );
            }
        } else {
            $this->info('No AI losses scheduled for this tick.');
        }

        // 2. Process movement/return of all lost birds
        $lostPigeons = \App\Models\Pigeon::where('status', 'lost')->get();
        foreach ($lostPigeons as $pigeon) {
            // Return if lost for > 24 hours
            if ($pigeon->lost_at && $pigeon->lost_at->addHours(24)->isPast()) {
                $pigeon->update([
                    'status' => 'idle',
                    'stray_at_loft_id' => null,
                    'lost_at' => null,
                    'loyalty' => min(100, $pigeon->loyalty + 5),
                ]);
                (new \App\Services\ActivityService())->log($pigeon->loft, "{$pigeon->name} has finally found its way back home after being lost!");
                continue;
            }

            // Move to a new random player loft
            $newRandomLoft = \App\Models\Loft::where('id', '!=', $pigeon->loft_id)
                ->where('id', '!=', $pigeon->stray_at_loft_id)
                ->whereHas('user', fn($q) => $q->where('is_ai', false))
                ->inRandomOrder()
                ->first();

            if ($newRandomLoft) {
                $pigeon->update(['stray_at_loft_id' => $newRandomLoft->id]);
            }
        }

        $this->info('Lost pigeons processed successfully.');
    }
}
