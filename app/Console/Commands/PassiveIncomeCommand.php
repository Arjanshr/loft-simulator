<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

class PassiveIncomeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pigeons:passive-income';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate passive income for lofts based on Fancy pigeon aesthetics.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \App\Models\Pigeon::where('status', '!=', 'chick')
            ->with('loft')
            ->chunk(100, function ($pigeons) {
                foreach ($pigeons as $pigeon) {
                    // 1. Passive Income for Fancy types
                    if ($pigeon->type === 'fancy') {
                        $chance = 10 + ($pigeon->beauty / 2); // 10% to ~60% chance
                        if (rand(1, 100) <= $chance) {
                            $income = 1 + (int)($pigeon->beauty / 20);
                            $pigeon->loft->increment('coins', $income);
                        }
                    }

                    // 2. Passive Vitamin generation for Highflyers
                    if ($pigeon->type === 'highflyer') {
                        $chance = 5 + ($pigeon->speed / 5); // 5% to ~25% chance
                        if (rand(1, 100) <= $chance) {
                            $pigeon->loft->increment('vitamins', 1);
                        }
                    }

                    // 3. Passive Token generation for Racers
                    if ($pigeon->type === 'racer') {
                        $chance = 5 + ($pigeon->speed / 5); // 5% to ~25% chance
                        if (rand(1, 100) <= $chance) {
                            $pigeon->loft->increment('tokens', 1);
                        }
                    }

                    // 4. Passive Loyalty growth for all
                    if ($pigeon->loyalty < 100) {
                        $pigeon->increment('loyalty');
                    }
                }
            });

        $this->info('Passive income and loyalty growth processed successfully.');
    }
}
