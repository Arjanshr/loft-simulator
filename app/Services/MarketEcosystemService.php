<?php

namespace App\Services;

use App\Models\Listing;
use App\Models\Loft;
use App\Models\Pigeon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MarketEcosystemService
{
    /**
     * Simulate a single market tick.
     * A market tick handles AI listing and AI purchasing.
     */
    public function tick(): void
    {
        $this->simulateAiListings();
        $this->simulateAiPurchases();
    }

    /**
     * AI lofts occasionally list idle pigeons for sale.
     */
    private function simulateAiListings(): void
    {
        $aiLofts = Loft::whereHas('user', fn($q) => $q->where('is_ai', true))->inRandomOrder()->limit(5)->get();

        foreach ($aiLofts as $loft) {
            // Pick an idle adult pigeon to list
            $pigeon = $loft->pigeons()
                ->where('status', 'idle')
                ->where('birth_at', '<=', now()->subDays(4))
                ->inRandomOrder()
                ->first();

            \Illuminate\Support\Facades\Log::info("AI Market Tick: Checking loft {$loft->name}. Found pigeon: " . ($pigeon ? $pigeon->name : 'none'));

            if ($pigeon) { 
                (new MarketplaceService())->listPigeon($pigeon, $pigeon->fixed_price);
                \Illuminate\Support\Facades\Log::info("AI Market Tick: Listed {$pigeon->name} for {$pigeon->fixed_price}.");
            }
        }
    }

    /**
     * AI lofts look for pigeons listed by others (AI or Players) within level ±1.
     */
    private function simulateAiPurchases(): void
    {
        $aiLofts = Loft::whereHas('user', fn($q) => $q->where('is_ai', true))->inRandomOrder()->limit(5)->get();

        foreach ($aiLofts as $buyerLoft) {
            $minLevel = max(1, $buyerLoft->level - 1);
            $maxLevel = min(100, $buyerLoft->level + 1);

            // Find an active listing within level range and budget
            $listing = Listing::where('is_active', true)
                ->where('loft_id', '!=', $buyerLoft->id)
                ->whereHas('pigeon', function($q) use ($maxLevel) {
                    // Buyers (including AI) can only buy up to Loft Level + 1
                    $q->where('level', '<=', $maxLevel);
                })
                ->where('price', '<=', $buyerLoft->coins + 500) // AI can stretch budget a bit
                ->inRandomOrder()
                ->first();

            if ($listing && rand(1, 100) <= 15) { // 15% chance to buy per tick
                // If AI doesn't have enough coins, we give them a small "injection" for the sim
                if ($buyerLoft->coins < $listing->price) {
                    $buyerLoft->increment('coins', $listing->price - $buyerLoft->coins);
                }
                
                (new MarketplaceService())->buyPigeon($listing, $buyerLoft);
            }
        }
    }
}
