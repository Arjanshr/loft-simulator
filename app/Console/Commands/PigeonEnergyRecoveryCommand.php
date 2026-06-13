<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

class PigeonEnergyRecoveryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pigeons:recover-energy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recover 1% energy for all pigeons every 2 minutes.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \App\Models\Pigeon::where('status', '!=', 'egg')
            ->where('energy', '<', 100)
            ->increment('energy', 1);

        $this->info('Vitality recovery sequence processed.');
    }
}
