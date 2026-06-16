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
                        // Formula: 1 base coin + (beauty score / 10)
                        $income = 1 + ($pigeon->beauty / 10);
                        $pigeon->loft->increment('coins', (int) $income);
                    }

                    // 2. Passive Loyalty growth for all
                    if ($pigeon->loyalty < 100) {
                        $pigeon->increment('loyalty');
                    }
                }
            });

        $this->info('Passive income and loyalty growth processed successfully.');
    }
}
