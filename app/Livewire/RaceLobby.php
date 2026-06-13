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
        $user = Auth::user();
        
        if (!$this->selectedPigeonId) {
            session()->flash('race_error', "Please select a pigeon first.");
            return;
        }

        $pigeon = $loft->pigeons()->findOrFail($this->selectedPigeonId);

        // --- NEW CONSTRAINTS ---
        // 1. Level check
        if ($user->loft->level < $race->level_requirement) {
            session()->flash('race_error', "Your loft level is too low for this race.");
            return;
        }

        // 2. Type check
        if ($race->race_type === 'exhibition' && $pigeon->type !== 'fancy') {
            session()->flash('race_error', "Only fancy pigeons can enter exhibitions.");
            return;
        }
        if ($race->race_type === 'highflyer' && $pigeon->type !== 'highflyer') {
            session()->flash('race_error', "Only highflyers can enter highflyer tournaments.");
            return;
        }
        if ($race->race_type === 'racing' && $pigeon->type !== 'racer') {
            session()->flash('race_error', "Only racers can enter racing tournaments.");
            return;
        }
        // -----------------------

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
        $loft = Auth::user()->loft;
        
        $query = Race::query();
        
        // Only show exhibition races to players with loft level < 5
        if ($loft->level < 5) {
            $query->where('race_type', 'exhibition');
        }

        return view('livewire.race-lobby', [
            'races' => $query->latest()->get(),
            'readyPigeons' => $loft->pigeons()->where('status', 'idle')->where('energy', '>=', 50)->get() ?? collect(),
        ]);
    }
}
