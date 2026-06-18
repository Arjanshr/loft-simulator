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
        $lostBirdChance = max(0, min(100, (int) $settingsService->get('ai_lost_bird_chance', 20)));

        // 1. Trigger new lost birds (AI Lofts)
        $aiLofts = \App\Models\Loft::whereHas('user', fn($q) => $q->where('is_ai', true))->get();
        foreach ($aiLofts as $loft) {
            $pigeon = $loft->pigeons()
                ->where('status', 'idle')
                ->where('loyalty', '<', 30)
                ->inRandomOrder()
                ->first();

            if ($pigeon && rand(1, 100) <= $lostBirdChance) {
                $randomLoft = \App\Models\Loft::where('id', '!=', $loft->id)->inRandomOrder()->first();
                if ($randomLoft) {
                    $pigeon->update([
                        'status' => 'lost',
                        'lost_at' => now(),
                        'stray_at_loft_id' => $randomLoft->id
                    ]);
                    \Illuminate\Support\Facades\Log::info("Process Lost Birds: AI pigeon {$pigeon->name} got lost from {$loft->name} at {$lostBirdChance}% chance.");
                }
            }
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
