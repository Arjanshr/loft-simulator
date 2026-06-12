<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Loft;
use App\Models\Pigeon;
use App\Models\Race;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Test User and Loft
        $user = User::factory()->create([
            'name' => 'Pro Racer',
            'email' => 'pro@pigeon.com',
            'password' => bcrypt('password'),
        ]);

        $loft = Loft::create([
            'user_id' => $user->id,
            'name' => 'Victory Loft',
            'coins' => 5000,
            'level' => 1,
            'xp' => 0,
        ]);

        // Create 3 starter pigeons for the user
        for ($i = 1; $i <= 3; $i++) {
            Pigeon::create([
                'loft_id' => $loft->id,
                'name' => "Flash #$i",
                'speed' => rand(20, 30),
                'endurance' => rand(20, 30),
                'navigation' => rand(20, 30),
                'temperament' => rand(20, 30),
                'energy' => 100,
            ]);
        }

        // 2. Create AI Lofts and Pigeons
        for ($i = 1; $i <= 5; $i++) {
            $aiUser = User::factory()->create(['name' => "AI Trainer $i"]);
            $aiLoft = Loft::create([
                'user_id' => $aiUser->id,
                'name' => "AI Loft $i",
                'coins' => 0,
            ]);

            for ($j = 1; $j <= 2; $j++) {
                Pigeon::create([
                    'loft_id' => $aiLoft->id,
                    'name' => "AI Bird $i-$j",
                    'speed' => rand(15, 35),
                    'endurance' => rand(15, 35),
                    'navigation' => rand(15, 35),
                    'temperament' => rand(15, 35),
                    'energy' => 100,
                ]);
            }
        }

        // 3. Create Races
        Race::create([
            'title' => 'Beginner Sprint',
            'distance_km' => 100,
            'difficulty_tier' => 1,
            'entry_fee' => 50,
            'prize_pool' => 500,
        ]);

        Race::create([
            'title' => 'Coastal Classic',
            'distance_km' => 300,
            'difficulty_tier' => 2,
            'entry_fee' => 200,
            'prize_pool' => 2000,
        ]);

        Race::create([
            'title' => 'Grand Mountain Marathon',
            'distance_km' => 600,
            'difficulty_tier' => 3,
            'entry_fee' => 500,
            'prize_pool' => 5000,
        ]);
    }
}
