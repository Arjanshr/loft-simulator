<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Loft;
use App\Models\Pigeon;
use App\Services\PairingService;
use App\Services\BreedingService;
use Illuminate\Support\Facades\Auth;

class BreedingCenter extends Component
{
    public $maleId;
    public $femaleId;

    public function createPair(PairingService $pairingService)
    {
        $this->validate([
            'maleId' => 'required',
            'femaleId' => 'required',
        ]);

        $loft = Auth::user()->loft;
        
        if ($pairingService->createPair($loft, (int)$this->maleId, (int)$this->femaleId)) {
            $this->reset(['maleId', 'femaleId']);
            session()->flash('message', 'Pair formed successfully!');
        } else {
            session()->flash('error', 'Could not form pair. Ensure pigeons are adult, different genders, and not related.');
        }
    }

    public function breedPair($pairId, BreedingService $breedingService)
    {
        $pair = \App\Models\Pair::findOrFail($pairId);

        if ($breedingService->breed($pair)) {
            session()->flash('message', 'Incubation started!');
        } else {
            session()->flash('error', 'Could not start breeding.');
        }
    }

    public function hatch($recordId, BreedingService $breedingService)
    {
        $record = \App\Models\BreedingRecord::findOrFail($recordId);
        
        // Safety check: only hatch if 24h passed
        if ($record->eggs_laid_at->addDay()->isFuture()) {
            session()->flash('error', 'Eggs are still incubating.');
            return;
        }

        $breedingService->hatchEgg($record);
        session()->flash('message', 'Congratulations! 2 chicks have hatched and moved to your loft.');
    }

    public function disband($pairId, PairingService $pairingService)
    {
        $loft = Auth::user()->loft;
        
        if ($pairingService->disbandPair($loft, $pairId)) {
            session()->flash('message', 'Pair disbanded!');
        } else {
            session()->flash('error', 'Could not disband pair.');
        }
    }

    public function render()
    {
        $loft = Auth::user()->loft;
        
        $pairedPigeonIds = \App\Models\Pair::where('is_active', true)
            ->where('loft_id', $loft->id)
            ->pluck('male_id')
            ->merge(\App\Models\Pair::where('is_active', true)->where('loft_id', $loft->id)->pluck('female_id'));

        return view('livewire.breeding-center', [
            'males' => $loft->pigeons()
                ->where('gender', 'male')
                ->where('status', 'idle')
                ->whereNotIn('id', $pairedPigeonIds)
                ->where('birth_at', '<=', now()->subDays(4))
                ->get(),
            'females' => $loft->pigeons()
                ->where('gender', 'female')
                ->where('status', 'idle')
                ->whereNotIn('id', $pairedPigeonIds)
                ->where('birth_at', '<=', now()->subDays(4))
                ->get(),
            'pairs' => $loft->pairs()->with(['male', 'female'])->where('is_active', true)->get(),
            'breedingRecords' => $loft->breedingRecords()->get(),
        ])->layout('layouts.app', ['header' => 'Breeding Center']);
    }
}
