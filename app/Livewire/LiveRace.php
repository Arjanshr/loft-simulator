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
    public $pigeonId;
    public $race;
    public $results = null;
    public $isSimulating = true;

    public function mount($raceId, $pigeonId)
    {
        $this->raceId = $raceId;
        $this->pigeonId = $pigeonId;
        $this->race = Race::findOrFail($raceId);
    }

    public function startSimulation(RaceSimulationService $simulationService, \App\Services\MatchmakingService $matchmakingService)
    {
        $race = Race::findOrFail($this->raceId);
        $playerPigeon = Pigeon::findOrFail($this->pigeonId);
        
        // Use MatchmakingService to find appropriately leveled opponents
        $opponents = $matchmakingService->getOpponents($playerPigeon->loft, 7);
            
        $competitors = $opponents->push($playerPigeon);
        
        $this->results = $simulationService->simulate($race, $competitors);
        
        // Reduce energy further (total 30 from entry + simulation)
        $playerPigeon->decrement('energy', 10);
        
        $this->isSimulating = false;
    }

    public function render()
    {
        return view('livewire.live-race')
            ->layout('layouts.app', ['header' => 'Live Race Results']);
    }
}
