<?php

namespace App\Services;

use App\Models\Listing;
use App\Models\Loft;
use App\Models\Pigeon;
use App\Services\ActivityService;
use Illuminate\Support\Facades\DB;

class MarketplaceService
{
    public function listPigeon(Pigeon $pigeon, int $price): bool
    {
        if ($pigeon->status !== 'idle' || ($pigeon->sire_id !== null && $pigeon->birth_at->addDays(4)->isFuture())) {
            // Can't sell if busy, or juvenile
            return false;
        }

        Listing::create([
            'loft_id' => $pigeon->loft_id,
            'pigeon_id' => $pigeon->id,
            'price' => $price,
            'is_active' => true,
        ]);

        $pigeon->update(['status' => 'for_sale']);
        (new ActivityService())->log($pigeon->loft, "Listed {$pigeon->name} for {$price} 💰.");

        return true;
    }

    public function buyPigeon(Listing $listing, Loft $buyerLoft): bool
    {
        $sellerLoft = $listing->loft;
        $pigeon = $listing->pigeon;

        if ($buyerLoft->id === $sellerLoft->id) {
            return false; // Can't buy own pigeon
        }

        if ($buyerLoft->coins < $listing->price) {
            return false; // Insufficient funds
        }

        DB::transaction(function () use ($listing, $buyerLoft, $sellerLoft, $pigeon) {
            // 1. Transfer coins
            $buyerLoft->decrement('coins', $listing->price);
            $sellerLoft->increment('coins', $listing->price);

            // 2. Transfer ownership
            $pigeon->update([
                'loft_id' => $buyerLoft->id,
                'status' => 'idle',
            ]);

            // 3. Close listing
            $listing->update(['is_active' => false]);
        });
        
        (new ActivityService())->log($buyerLoft, "Bought {$pigeon->name} for {$listing->price} 💰.");
        (new ActivityService())->log($sellerLoft, "Sold {$pigeon->name} for {$listing->price} 💰.");

        return true;
    }
}
