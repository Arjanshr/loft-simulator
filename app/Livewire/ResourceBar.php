<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ResourceBar extends Component
{
    #[On('loft-updated')]
    public function refresh()
    {
        // Property access to Auth::user()->loft is fresh on every render
    }

    public function render()
    {
        return view('livewire.resource-bar', [
            'loft' => Auth::user()->loft,
        ]);
    }
}
