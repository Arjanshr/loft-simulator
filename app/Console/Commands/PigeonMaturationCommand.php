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

        // 1. Process Hatching
        \App\Models\BreedingRecord::where('eggs_laid_at', '<=', now()->subDay())->each(function ($record) {
            $breedingService = new \App\Services\BreedingService();
            $breedingService->hatchEgg($record);
        });

        // 2. Process Maturation
        \App\Models\Pigeon::chunk(100, function ($pigeons) use ($beautyAttributes) {
            foreach ($pigeons as $pigeon) {
                // Passive Energy Recovery
                if ($pigeon->status === 'idle' && $pigeon->energy < 100) {
                    $pigeon->increment('energy', 5);
                    if ($pigeon->energy > 100) $pigeon->update(['energy' => 100]);
                }

                $updates = [];
                foreach ($beautyAttributes as $attribute) {
                    // 5% chance per hour to increase by 1/12
                    if (rand(1, 100) <= 5) {
                        $updates[$attribute] = min(100, $pigeon->{$attribute} + (1 / 12));
                    }
                }

                if (!empty($updates)) {
                    $pigeon->update($updates);
                }
            }
        });

        $this->info('Pigeon maturation and incubation processed successfully.');
    }
}
