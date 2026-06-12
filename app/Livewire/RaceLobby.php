<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Race;
use App\Models\Pigeon;
use Illuminate\Support\Facades\Auth;

class RaceLobby extends Component
{
    public $selectedPigeonId = null;

    public function enterRace($raceId)
    {
        $race = Race::findOrFail($raceId);
        $loft = Auth::user()->loft;
        
        if (!$this->selectedPigeonId) {
            session()->flash('race_error', "Please select a pigeon first.");
            return;
        }

        $pigeon = $loft->pigeons()->findOrFail($this->selectedPigeonId);

        if ($loft->coins < $race->entry_fee) {
            session()->flash('race_error', "Not enough coins.");
            return;
        }

        if ($pigeon->status !== 'idle' || $pigeon->energy < 50) {
            session()->flash('race_error', "Pigeon is not ready (needs 50% energy).");
            return;
        }

        // Deduct fee
        $loft->decrement('coins', $race->entry_fee);
        
        // Mark pigeon as racing
        $pigeon->update(['status' => 'racing']);

        return redirect()->route('race.live', ['raceId' => $race->id, 'pigeonId' => $pigeon->id]);
    }

    public function render()
    {
        return view('livewire.race-lobby', [
            'races' => Race::latest()->get(),
            'readyPigeons' => Auth::user()->loft?->pigeons()->where('status', 'idle')->where('energy', '>=', 50)->get() ?? collect(),
        ]);
    }
}
