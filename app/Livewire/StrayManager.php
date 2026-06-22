<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pigeon;
use App\Models\Loft;
use App\Services\ActivityService;
use Illuminate\Support\Facades\Auth;

class StrayManager extends Component
{
    public function attemptCatch($pigeonId)
    {
        $userLoft = Auth::user()->loft;
        $pigeon = Pigeon::where('id', $pigeonId)->where('stray_at_loft_id', $userLoft->id)->firstOrFail();

        if ($userLoft->pigeons()->count() >= $userLoft->capacity) {
            $this->dispatch('notify', message: "Your loft is at max capacity ({$userLoft->capacity}). Sell a bird to capture strays.", type: 'error');
            return;
        }

        // Formula: Base 15% + (Host Loft Level - Bird Level) * 2%
        $chance = 15 + ($userLoft->level - $pigeon->level) * 2;
        $chance = max(5, min(95, $chance));

        if (rand(1, 100) <= $chance) {
            // Success
            $originalLoft = $pigeon->loft;
            
            $pigeon->update([
                'loft_id' => $userLoft->id,
                'status' => 'idle',
                'stray_at_loft_id' => null,
                'lost_at' => null,
                'loyalty' => 10,
            ]);

            (new ActivityService())->log($userLoft, "SUCCESS: You successfully captured a stray pigeon: {$pigeon->name} (Lv.{$pigeon->level})!");
            (new ActivityService())->log($originalLoft, "NOTICE: Your lost pigeon {$pigeon->name} has been captured by another loft and is no longer returning home.");
            
            $this->dispatch('notify', message: "Great work! {$pigeon->name} has been added to your loft.", type: 'success');
        } else {
            // Failure - Bird moves to a new random loft
            $newRandomLoft = Loft::where('id', '!=', $pigeon->loft_id)
                ->where('id', '!=', $userLoft->id)
                ->inRandomOrder()
                ->first();

            if ($newRandomLoft) {
                $pigeon->update(['stray_at_loft_id' => $newRandomLoft->id]);
            }

            $this->dispatch('notify', message: "The bird got spooked and flew away to another area!", type: 'error');
        }

        $this->dispatch('loft-updated');
    }

    public function render()
    {
        $userLoft = Auth::user()->loft;
        $strays = $userLoft ? Pigeon::where('stray_at_loft_id', $userLoft->id)->get() : collect();

        return view('livewire.stray-manager', [
            'strays' => $strays,
        ]);
    }
}
