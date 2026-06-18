<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pigeon;
use App\Models\Listing;
use App\Services\MarketplaceService;
use Illuminate\Support\Facades\Auth;

class MyListings extends Component
{
    public $price = [];

    public function listPigeon($pigeonId, MarketplaceService $marketplaceService)
    {
        $pigeon = Auth::user()->loft->pigeons()->findOrFail($pigeonId);
        
        if ($marketplaceService->listPigeon($pigeon)) {
            session()->flash('message', "Pigeon listed for {$pigeon->fixed_price} 💰!");
        } else {
            session()->flash('error', 'Could not list pigeon.');
        }
    }

    public function render()
    {
        $loft = Auth::user()->loft;
        
        return view('livewire.my-listings', [
            'idlePigeons' => $loft->pigeons()->where('status', 'idle')->get(),
            'myListings' => Listing::where('loft_id', $loft->id)->where('is_active', true)->with('pigeon')->get(),
        ]);
    }
}
