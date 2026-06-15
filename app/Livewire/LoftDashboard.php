<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Services\LoftService;

use Livewire\Attributes\On;

class LoftDashboard extends Component
{
    public $loftName = '';
    public $showCreateForm = false;

    #[On('loft-updated')]
    public function refreshLoft()
    {
        // Simply re-rendering is enough as render() uses Auth::user()->loft
    }

    public function upgrade(LoftService $loftService)
    {
        if ($loftService->upgradeLoft(Auth::user()->loft)) {
            $this->dispatch('loft-updated');
            $this->dispatch('notify', message: 'Loft upgraded successfully!', type: 'success');
        } else {
            $this->dispatch('notify', message: 'Not enough XP or coins to upgrade.', type: 'error');
        }
    }

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
