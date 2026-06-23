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
    public function handle(): void
    {
        \App\Models\Pigeon::where('status', '!=', 'chick')
            ->with('loft')
            ->chunk(100, function ($pigeons) {
                foreach ($pigeons as $pigeon) {
                    $reward = $pigeon->passiveReward();

                    if (
                        $reward['resource'] &&
                        random_int(1, 100) <= $reward['chance']
                    ) {
                        $pigeon->loft->increment(
                            $reward['resource'],
                            $reward['amount']
                        );
                    }

                    if ($pigeon->loyalty < 100) {
                        $pigeon->increment('loyalty');
                    }
                }
            });

        $this->info('Passive income and loyalty growth processed successfully.');
    }
}
