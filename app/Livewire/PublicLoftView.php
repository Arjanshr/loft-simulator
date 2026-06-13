<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Loft;

class PublicLoftView extends Component
{
    public $loft;

    public function mount($loftId)
    {
        $this->loft = Loft::with('pigeons')->findOrFail($loftId);
    }

    public function render()
    {
        return view('livewire.public-loft-view')->layout('layouts.app', ['header' => $this->loft->name . "'s Loft"]);
    }
}
