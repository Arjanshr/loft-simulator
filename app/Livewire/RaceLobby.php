<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Race;
use App\Models\Pigeon;
use Illuminate\Support\Facades\Auth;

class RaceLobby extends Component
{
    public $selectedPigeonIds = [];
    public $rewardMultiplier = 1;

    public function enterRace($raceId)
    {
        $race = Race::findOrFail($raceId);
        $loft = Auth::user()->loft;
        $user = Auth::user();
        
        if (empty($this->selectedPigeonIds)) {
            session()->flash('race_error', "Please select at least one pigeon.");
            return;
        }

        $pigeons = $loft->pigeons()->whereIn('id', $this->selectedPigeonIds)->get();

        // --- NEW CONSTRAINTS ---
        // 1. Level check
        if ($user->loft->level < $race->level_requirement) {
            session()->flash('race_error', "Your loft level is too low for this race.");
            return;
        }

        foreach ($pigeons as $pigeon) {
            // 2. Type check
            if ($race->race_type === 'exhibition' && $pigeon->type !== 'fancy') {
                session()->flash('race_error', "Only fancy pigeons can enter exhibitions. ({$pigeon->name} is {$pigeon->type})");
                return;
            }
            if ($race->race_type === 'highflyer' && $pigeon->type !== 'highflyer') {
                session()->flash('race_error', "Only highflyers can enter highflyer tournaments. ({$pigeon->name} is {$pigeon->type})");
                return;
            }
            if ($race->race_type === 'racing' && $pigeon->type !== 'racer') {
                session()->flash('race_error', "Only racers can enter racing tournaments. ({$pigeon->name} is {$pigeon->type})");
                return;
            }

            // All races use tokens — only require idle status, no stamina check
            if ($pigeon->status !== 'idle') {
                session()->flash('race_error', "Pigeon {$pigeon->name} is not idle.");
                return;
            }
        }
        // -----------------------

        $totalEntryFee = $race->entry_fee * $this->rewardMultiplier * $pigeons->count();

        // All tournaments cost tokens
        $currencyColumn = 'tokens';
        $currencyLabel  = 'tokens';

        if ($loft->{$currencyColumn} < $totalEntryFee) {
            session()->flash('race_error', "Not enough {$currencyLabel} for entry fee.");
            return;
        }

        // Deduct fee
        $loft->decrement($currencyColumn, $totalEntryFee);
        
        // Mark pigeon as racing
        foreach ($pigeons as $pigeon) {
            $pigeon->update(['status' => 'racing']);
        }

        return redirect()->route('race.live', ['raceId' => $race->id, 'pigeons' => implode(',', $this->selectedPigeonIds), 'multiplier' => $this->rewardMultiplier]);
    }

    public function render()
    {
        $loft = Auth::user()->loft;
        $selectedType = request()->query('type');
        $allowedTypes = ['exhibition', 'highflyer', 'racing'];
        
        $query = Race::query();

        if (in_array($selectedType, $allowedTypes, true)) {
            $query->where('race_type', $selectedType);
        }
        
        // Only show exhibition races to players with loft level < 5
        if ($loft->level < 5) {
            $query->where('race_type', 'exhibition');
        }

        return view('livewire.race-lobby', [
            'races' => $query->latest()->get(),
            'readyPigeons' => $loft->pigeons()->where('status', 'idle')->get() ?? collect(),
            'activeRaceType' => in_array($selectedType, $allowedTypes, true) ? $selectedType : null,
        ]);
    }
}
