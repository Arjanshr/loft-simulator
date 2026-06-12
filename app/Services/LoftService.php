<?php

namespace App\Services;

use App\Models\User;
use App\Models\Loft;
use App\Models\Pigeon;

class LoftService
{
    public function setupForUser(User $user, string $loftName): Loft
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($user, $loftName) {
            $loft = Loft::create([
                'user_id' => $user->id,
                'name' => $loftName,
                'coins' => 1000,
                'level' => 1,
            ]);

            $pigeonService = new PigeonService();
            for ($i = 1; $i <= 3; $i++) {
                $pigeonService->createStarter($loft, "Starter Bird #$i");
            }

            return $loft;
        });
    }
}
