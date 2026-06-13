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
        \App\Models\Pigeon::where('type', 'fancy')
            ->where('status', '!=', 'egg')
            ->with('loft')
            ->chunk(100, function ($pigeons) {
                foreach ($pigeons as $pigeon) {
                    // Formula: 1 base coin + (beauty score / 10)
                    $income = 1 + ($pigeon->beauty / 10);
                    $pigeon->loft->increment('coins', (int) $income);
                }
            });

        $this->info('Passive income distributed successfully.');
    }
}
