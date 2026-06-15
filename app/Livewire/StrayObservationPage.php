<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pigeon;
use App\Models\Loft;
use App\Services\ActivityService;
use Illuminate\Support\Facades\Auth;

class StrayObservationPage extends Component
{
    public function attemptCatch($pigeonId)
    {
        $userLoft = Auth::user()->loft;
        $pigeon = Pigeon::where('id', $pigeonId)->where('stray_at_loft_id', $userLoft->id)->firstOrFail();

        // Formula: Base 15% + (Host Loft Level - Bird Level) * 2%
        $chance = 15 + ($userLoft->level - $pigeon->level) * 2;
        $chance = max(5, min(95, $chance));

        if (rand(1, 100) <= $chance) {
            $originalLoft = $pigeon->loft;
            
            $pigeon->update([
                'loft_id' => $userLoft->id,
                'status' => 'idle',
                'stray_at_loft_id' => null,
                'lost_at' => null,
                'loyalty' => 10,
            ]);

            (new ActivityService())->log($userLoft, "SUCCESS: Captured stray: {$pigeon->name} (Lv.{$pigeon->level})!");
            (new ActivityService())->log($originalLoft, "NOTICE: Your lost pigeon {$pigeon->name} has been captured.");

            $this->dispatch('notify', message: "Great work! {$pigeon->name} has been added to your loft.", type: 'success');
        } else {
            $newRandomLoft = Loft::where('id', '!=', $pigeon->loft_id)
                ->where('id', '!=', $userLoft->id)
                ->inRandomOrder()
                ->first();

            if ($newRandomLoft) {
                $pigeon->update(['stray_at_loft_id' => $newRandomLoft->id]);
            }

            $this->dispatch('notify', message: "The bird got spooked and flew away!", type: 'error');
        }
    }

    public function render()
    {
        $userLoft = Auth::user()->loft;
        $strays = $userLoft ? Pigeon::where('stray_at_loft_id', $userLoft->id)->get() : collect();

        // Fetch all birds that are currently lost in the world
        $globalLostBirds = Pigeon::where('status', 'lost')
            ->whereNotNull('stray_at_loft_id')
            ->with('loft')
            ->orderBy('lost_at', 'desc')
            ->get();

        return view('livewire.stray-observation-page', [
            'strays' => $strays,
            'globalLostBirds' => $globalLostBirds,
        ])->layout('layouts.app', ['header' => 'Stray Observation']);
    }
}
