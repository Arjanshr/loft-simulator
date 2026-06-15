<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('pigeons:debug-lost')]
#[Description('Debug AI pigeon data.')]
class DebugLostBirdsCommand extends Command
{
    public function handle()
    {
        $lostCount = \App\Models\Pigeon::where('status', 'lost')->count();
        $this->info('Total lost birds: ' . $lostCount);

        $aiLofts = \App\Models\Loft::whereHas('user', fn($q) => $q->where('is_ai', true))->get();
        $this->info('Found ' . $aiLofts->count() . ' AI lofts.');

        foreach ($aiLofts as $loft) {
            $pigeons = $loft->pigeons;
            $this->info("Loft {$loft->id} ({$loft->name}) has {$pigeons->count()} pigeons.");
            foreach ($pigeons as $pigeon) {
                if ($pigeon->status == 'idle' && $pigeon->loyalty < 30) {
                    $this->line("- Pigeon {$pigeon->name} (ID: {$pigeon->id}) is IDLE, Loyalty: {$pigeon->loyalty}");
                }
            }
        }
    }
}
