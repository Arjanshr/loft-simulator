<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\PigeonService;

class PigeonManager extends Component
{
    public $newName = [];

    public function updateName($pigeonId)
    {
        $pigeon = Auth::user()->loft->pigeons()->findOrFail($pigeonId);
        
        $this->validate([
            'newName.' . $pigeonId => 'required|string|min:2|max:20',
        ]);

        $pigeon->update(['name' => $this->newName[$pigeonId]]);
        
        $this->newName[$pigeonId] = '';
        session()->flash('message', "Pigeon renamed to {$pigeon->name}!");
    }

    public function train($pigeonId, $stat, PigeonService $pigeonService)
    {
        $pigeon = Auth::user()->loft->pigeons()->findOrFail($pigeonId);
        
        if ($pigeonService->train($pigeon, $stat)) {
            session()->flash('message', "{$pigeon->name} improved their {$stat}!");
        } else {
            session()->flash('error', "Not enough energy or training is on cooldown.");
        }
    }

    public function improveAesthetic($pigeonId, $attribute, PigeonService $pigeonService)
    {
        $pigeon = Auth::user()->loft->pigeons()->findOrFail($pigeonId);
        
        if ($pigeonService->improveAesthetics($pigeon, $attribute)) {
            $this->dispatch('loft-updated');
            session()->flash('message', "{$pigeon->name}'s " . str_replace('_', ' ', $attribute) . " improved!");
        } else {
            session()->flash('error', "Not enough coins or attribute maxed out.");
        }
    }

    public function rest($pigeonId, PigeonService $pigeonService)
    {
        $pigeon = Auth::user()->loft->pigeons()->findOrFail($pigeonId);
        
        if ($pigeonService->instantRest($pigeon)) {
            $this->dispatch('loft-updated');
            session()->flash('message', "{$pigeon->name} is fully rested!");
        } else {
            session()->flash('error', "Not enough coins or already rested.");
        }
    }

    public function levelUp($pigeonId, PigeonService $pigeonService)
    {
        $pigeon = Auth::user()->loft->pigeons()->findOrFail($pigeonId);
        
        if ($pigeonService->levelUpPigeon($pigeon)) {
            $this->dispatch('pigeon-leveled-up', name: $pigeon->name);
            $this->dispatch('loft-updated');
            session()->flash('message', "{$pigeon->name} leveled up to Lv.{$pigeon->level} and earned a reward!");
        } else {
            session()->flash('error', "Not enough training stats to level up.");
        }
    }

    public function render()
    {
        return view('livewire.pigeon-manager', [
            'pigeons' => Auth::user()->loft?->pigeons ?? collect(),
        ]);
    }
}
