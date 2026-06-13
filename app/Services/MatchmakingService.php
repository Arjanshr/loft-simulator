<?php

namespace App\Services;

use App\Models\Loft;
use App\Models\Pigeon;
use Illuminate\Support\Collection;

class MatchmakingService
{
    public function getOpponents(Loft $userLoft, int $count = 7): Collection
    {
        $minLevel = max(1, $userLoft->level - 1);
        $maxLevel = min(100, $userLoft->level + 1);

        return Pigeon::whereHas('loft', function ($query) use ($minLevel, $maxLevel) {
            $query->whereBetween('level', [$minLevel, $maxLevel])
                  ->whereNotNull('user_id'); // Ensure it's not the user
        })
        ->where('status', 'idle')
        ->inRandomOrder()
        ->limit($count)
        ->get();
    }
}
