<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pigeon;

class PigeonMaturationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pigeons:mature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Slowly increase beauty attributes of all pigeons over time.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $beautyAttributes = ['eyes', 'beak', 'legs', 'feather_quality', 'pattern', 'color', 'purity'];

        // 1. Process Hatching (BreedingRecord -> New Pigeon 'egg' status)
        \App\Models\BreedingRecord::where('eggs_laid_at', '<=', now()->subDay())->each(function ($record) {
            $breedingService = new \App\Services\BreedingService();
            $breedingService->hatchEgg($record);
        });

        // 2. Process Expired Listings
        \App\Models\Listing::where('is_active', true)->where('expires_at', '<=', now())->each(function ($listing) {
            $listing->update(['is_active' => false]);
            $listing->pigeon->update(['status' => 'idle']);
            (new \App\Services\ActivityService())->log($listing->loft, "Auction for {$listing->pigeon->name} expired. Unit returned to loft.");
        });

        // 3. Process Maturation
        \App\Models\Pigeon::chunk(100, function ($pigeons) use ($beautyAttributes) {
            foreach ($pigeons as $pigeon) {
                // Passive Energy Recovery (Only for non-eggs/hatchlings)
                if ($pigeon->status !== 'egg' && $pigeon->energy < 100) {
                    $pigeon->increment('energy', 5);
                    if ($pigeon->energy > 100) $pigeon->update(['energy' => 100]);
                }

                // Passive Beauty Growth (Only for Juveniles/Adults)
                if ($pigeon->birth_at && $pigeon->birth_at->addDays(2)->isPast()) {
                    $updates = [];
                    foreach ($beautyAttributes as $attribute) {
                        if (rand(1, 100) <= 5) {
                            $updates[$attribute] = min(100, $pigeon->{$attribute} + (1 / 12));
                        }
                    }
                    if (!empty($updates)) $pigeon->update($updates);
                }

                // --- Lifecycle Transitions ---
                // Hatching at exactly 1 day since laying? 
                // Wait, hatchEgg already creates the pigeon record with status 'egg'.
                // So: 
                // Status Egg -> Hatchling after 1 day? No, hatchEgg IS the hatching. 
                // Let's align with user: 
                // 3. Incubation period is 1 day. (Handled by BreedingRecord check above)
                // 4. After hatching another 1 day is required to be juvenile.
                
                if ($pigeon->status === 'egg' && $pigeon->created_at->addDay()->isPast()) {
                    $pigeon->update(['status' => 'idle']); // Becomes visible/active as unit
                    (new \App\Services\ActivityService())->log($pigeon->loft, "{$pigeon->name} has fully hatched!");
                }

                if ($pigeon->status === 'nursing' && $pigeon->updated_at->addDay()->isPast()) {
                    $pigeon->update(['status' => 'idle']);
                    (new \App\Services\ActivityService())->log($pigeon->loft, "{$pigeon->name} has finished nursing and is ready for action.");
                }
            }
        });

        $this->info('Pigeon maturation, incubation, and lifecycle transitions processed successfully.');
    }
}
