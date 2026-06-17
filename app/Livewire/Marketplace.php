<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Listing;
use App\Services\MarketplaceService;
use Illuminate\Support\Facades\Auth;

class Marketplace extends Component
{
    public $search = '';
    public $type = '';
    public $gender = '';
    public $minPrice = '';
    public $maxPrice = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'type' => ['except' => ''],
        'gender' => ['except' => ''],
    ];

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
        $userLoft = Auth::user()->loft;
        $userLevel = $userLoft->level;

        $query = Listing::where('is_active', true)
            ->where('expires_at', '>', now())
            ->where('loft_id', '!=', $userLoft->id)
            ->whereHas('pigeon', function($q) use ($userLevel) {
                $q->where(function($query) use ($userLevel) {
                    $query->where('level', '<=', $userLevel)
                          ->orWhere(function($q2) use ($userLevel) {
                              $q2->where('level', '=', $userLevel + 1)
                                 ->whereRaw('RAND() < 0.05');
                          });
                });

                if ($this->search) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                }
                if ($this->type) {
                    $q->where('type', $this->type);
                }
                if ($this->gender) {
                    $q->where('gender', $this->gender);
                }
            });

        if ($this->minPrice) {
            $query->where('price', '>=', $this->minPrice);
        }
        if ($this->maxPrice) {
            $query->where('price', '<=', $this->maxPrice);
        }

        return view('livewire.marketplace', [
            'listings' => $query->with(['pigeon', 'loft'])->latest()->limit(30)->get(),
        ])->layout('layouts.app', ['header' => 'The Exchange']);
    }
}
