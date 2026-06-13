<?php

namespace App\Services;

use App\Models\Loft;
use App\Models\Pigeon;
use App\Models\Pair;
use App\Services\ActivityService;
use Carbon\Carbon;

class PairingService
{
    public function createPair(Loft $loft, int $maleId, int $femaleId): bool
    {
        $male = $loft->pigeons()->where('id', $maleId)->where('gender', 'male')->first();
        $female = $loft->pigeons()->where('id', $femaleId)->where('gender', 'female')->first();

        if (!$male || !$female) {
            return false;
        }

        // Check Adulthood (4+ days old)
        if ($male->birth_at->addDays(4)->isFuture() || $female->birth_at->addDays(4)->isFuture()) {
            return false;
        }

        // Check if either is already paired
        $isAlreadyPaired = Pair::where('is_active', true)
            ->where(function($q) use ($maleId, $femaleId) {
                $q->where('male_id', $maleId)->orWhere('female_id', $maleId)
                  ->orWhere('male_id', $femaleId)->orWhere('female_id', $femaleId);
            })->exists();

        if ($isAlreadyPaired) {
            return false;
        }

        // Check cage limit (Loft level = capacity)
        if ($loft->pairs()->where('is_active', true)->count() >= $loft->level) {
            return false;
        }

        Pair::create([
            'loft_id' => $loft->id,
            'male_id' => $male->id,
            'female_id' => $female->id,
        ]);

        (new ActivityService())->log($loft, "Formed breeding pair: {$male->name} ♂ + {$female->name} ♀.");

        return true;
    }

    public function disbandPair(Loft $loft, int $pairId): bool
    {
        $pair = $loft->pairs()->where('id', $pairId)->where('is_active', true)->with(['male', 'female'])->first();

        if (!$pair) {
            return false;
        }

        $pair->update(['is_active' => false]);
        (new ActivityService())->log($loft, "Disbanded breeding pair: {$pair->male->name} + {$pair->female->name}.");
        return true;
    }
}
