<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\LoftService;

class LoftDashboard extends Component
{
    public $loftName = '';
    public $showCreateForm = false;

    public function mount()
    {
        if (!Auth::user()->loft) {
            $this->showCreateForm = true;
        }
    }

    public function createLoft(LoftService $loftService)
    {
        $this->validate([
            'loftName' => 'required|min:3|max:50',
        ]);

        $loftService->setupForUser(Auth::user(), $this->loftName);
        $this->showCreateForm = false;
        
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.loft-dashboard', [
            'loft' => Auth::user()->loft,
        ]);
    }
}
