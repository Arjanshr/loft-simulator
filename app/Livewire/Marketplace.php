<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Listing;
use App\Services\MarketplaceService;
use Illuminate\Support\Facades\Auth;

class Marketplace extends Component
{
    public function buy($listingId, MarketplaceService $marketplaceService)
    {
        $listing = Listing::findOrFail($listingId);
        $buyerLoft = Auth::user()->loft;

        if ($marketplaceService->buyPigeon($listing, $buyerLoft)) {
            $this->dispatch('loft-updated');
            session()->flash('message', 'Pigeon purchased successfully!');
        } else {
            session()->flash('error', 'Purchase failed: insufficient funds or invalid listing.');
        }
    }

    public function render()
    {
        return view('livewire.marketplace', [
            'listings' => Listing::where('is_active', true)
                ->where('loft_id', '!=', Auth::user()->loft->id)
                ->with(['pigeon', 'loft'])
                ->get(),
        ])->layout('layouts.app', ['header' => 'Marketplace']);
    }
}
