<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\PigeonService;

class PigeonManager extends Component
{
    public function train($pigeonId, $stat, PigeonService $pigeonService)
    {
        $pigeon = Auth::user()->loft->pigeons()->findOrFail($pigeonId);
        
        if ($pigeonService->train($pigeon, $stat)) {
            session()->flash('message', "{$pigeon->name} improved their {$stat}!");
        } else {
            session()->flash('error', "Not enough energy or training is on cooldown.");
        }
    }

    public function render()
    {
        return view('livewire.pigeon-manager', [
            'pigeons' => Auth::user()->loft?->pigeons ?? collect(),
        ]);
    }
}
