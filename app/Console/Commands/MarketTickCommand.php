<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

class MarketTickCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pigeons:market-tick';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process autonomous AI trading behaviors in the marketplace.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new \App\Services\MarketEcosystemService())->tick();
        $this->info('Market ecosystem tick processed successfully.');
    }
}
