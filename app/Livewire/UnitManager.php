<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Pigeon;
use App\Services\PigeonService;

class UnitManager extends Component
{
    use WithPagination;

    public $search = '';
    public $typeFilter = 'all';
    public $rarityFilter = 'all';
    public $sortBy = 'level';
    public $sortDir = 'desc';
    public $newName = [];

    protected $queryString = ['search', 'typeFilter', 'rarityFilter', 'sortBy', 'sortDir'];

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'typeFilter', 'rarityFilter', 'sortBy', 'sortDir'])) {
            $this->resetPage();
        }
    }

    public function rest($pigeonId, PigeonService $pigeonService)
    {
        $pigeon = Auth::user()->loft->pigeons()->findOrFail($pigeonId);
        if ($pigeonService->instantRest($pigeon)) {
            $this->dispatch('loft-updated');
            session()->flash('message', "{$pigeon->name} fully rested.");
        } else {
            session()->flash('error', "Not enough vitamins or already rested.");
        }
    }

    public function levelUp($pigeonId, PigeonService $pigeonService)
    {
        $pigeon = Auth::user()->loft->pigeons()->findOrFail($pigeonId);
        if ($pigeonService->levelUpPigeon($pigeon)) {
            $this->dispatch('loft-updated');
            $this->dispatch('pigeon-leveled-up', name: $pigeon->name);
            session()->flash('message', "{$pigeon->name} reached Level {$pigeon->level}!");
        } else {
            session()->flash('error', "Level up requirement not met.");
        }
    }

    public function updateName($pigeonId)
    {
        $pigeon = Auth::user()->loft->pigeons()->findOrFail($pigeonId);
        $this->validate(['newName.' . $pigeonId => 'required|string|min:2|max:20']);
        $pigeon->update(['name' => $this->newName[$pigeonId]]);
        $this->newName[$pigeonId] = '';
        session()->flash('message', "Renamed to {$pigeon->name}.");
    }

    public function render()
    {
        $query = Auth::user()->loft->pigeons()
            ->when($this->search, fn($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->typeFilter !== 'all', fn($q) => $q->where('type', $this->typeFilter))
            ->when($this->rarityFilter !== 'all', fn($q) => $q->where('rarity', $this->rarityFilter));

        // Note: sortBy total_score would require pre-calculation or sorting in collection
        // For performance with pagination, we'll stick to DB columns for now.
        $pigeons = $query->orderBy($this->sortBy, $this->sortDir)->paginate(10);

        return view('livewire.unit-manager', [
            'pigeons' => $pigeons,
        ]);
    }
}
