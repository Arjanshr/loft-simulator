<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Race;
use App\Models\Pigeon;
use App\Services\RaceSimulationService;
use Illuminate\Support\Facades\Auth;

class LiveRace extends Component
{
    public $raceId;
    public $pigeonIds = [];
    public $multiplier = 1;
    public $race;
    public $results = null;
    public $isSimulating = true;

    public function mount($raceId)
    {
        $this->raceId = $raceId;
        $this->pigeonIds = explode(',', request()->query('pigeons', ''));
        $this->multiplier = (int) request()->query('multiplier', 1);
        $this->race = Race::findOrFail($raceId);
    }

    public function startSimulation(RaceSimulationService $simulationService, \App\Services\MatchmakingService $matchmakingService)
    {
        $race = Race::findOrFail($this->raceId);
        $playerPigeons = Pigeon::whereIn('id', $this->pigeonIds)->get();
        
        if ($playerPigeons->isEmpty()) {
            return redirect()->route('tournaments');
        }

        // Use MatchmakingService to find appropriately leveled opponents
        $opponents = $matchmakingService->getOpponents($playerPigeons->first()->loft, max(1, 8 - $playerPigeons->count()));
            
        $competitors = $opponents->merge($playerPigeons);
        
        $this->results = $simulationService->simulate($race, $competitors, $this->pigeonIds, $this->multiplier);
        
        // Reduce energy further (total 30 from entry + simulation)
        foreach ($playerPigeons as $pigeon) {
            $pigeon->decrement('energy', 10);
        }
        
        $this->isSimulating = false;
    }

    public function redoRace()
    {
        $race = Race::findOrFail($this->raceId);

        return redirect()->route('tournaments', [
            'type' => $race->race_type,
        ]);
    }

    public function render()
    {
        return view('livewire.live-race')
            ->layout('layouts.app', ['header' => 'Live Race Results']);
    }
}
