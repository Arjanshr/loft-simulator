<?php

namespace App\Services;

use App\Models\User;
use App\Models\Loft;
use App\Models\Pigeon;
use App\Services\ActivityService;
use Illuminate\Support\Facades\DB;

class LoftService
{
    public function setupForUser(User $user, string $loftName): Loft
    {
        return DB::transaction(function () use ($user, $loftName) {
            $loft = Loft::create([
                'user_id' => $user->id,
                'name' => $loftName,
                'coins' => 10000,
                'vitamins' => 500,
                'tokens' => 1000,
                'level' => 1,
            ]);

            $pigeonService = new PigeonService();
            $pigeonService->createAdult($loft, 'Sire', 'male');
            $pigeonService->createAdult($loft, 'Dam', 'female');
            $pigeonService->createJuvenile($loft, 'Chick');

            return $loft;
        });
    }

    public function upgradeLoft(Loft $loft): bool
    {
        $nextLevel = $loft->level + 1;
        $xpRequired = pow($nextLevel, 3) * 25;
        $cost = $nextLevel * 500;

        if ($loft->xp < $xpRequired || $loft->coins < $cost) {
            return false;
        }

        DB::transaction(function () use ($loft, $nextLevel, $cost) {
            $loft->decrement('coins', $cost);
            $loft->update(['level' => $nextLevel]);
            (new ActivityService())->log($loft, "Loft upgraded to Level {$nextLevel}!");
        });

        return true;
    }
}
