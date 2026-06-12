<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RaceHistoryDisplay extends Component
{
    public function render()
    {
        return view('livewire.race-history-display', [
            'histories' => Auth::user()->loft?->raceHistories()->latest()->limit(5)->get() ?? collect(),
        ]);
    }
}
