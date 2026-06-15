<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('pigeons:debug-locations')]
#[Description('Debug lost bird locations.')]
class DebugLostLocationsCommand extends Command
{
    public function handle()
    {
        $lost = \App\Models\Pigeon::where('status', 'lost')->get();
        $this->info('Total lost birds: ' . $lost->count());
        foreach ($lost as $pigeon) {
            $this->line("Bird {$pigeon->name} (ID: {$pigeon->id}) is at Loft {$pigeon->stray_at_loft_id}");
        }
    }
}
