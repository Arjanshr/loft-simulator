<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class LoftActivity extends Component
{
    #[On('loft-updated')]
    public function render()
    {
        return view('livewire.loft-activity', [
            'activities' => Auth::user()->loft->activityLogs()->latest()->limit(10)->get(),
        ]);
    }
}
