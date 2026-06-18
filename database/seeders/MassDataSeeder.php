<?php

namespace Database\Seeders;

use App\Models\FAQ;
use App\Models\Listing;
use App\Models\Loft;
use App\Models\Pigeon;
use App\Models\Race;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MassDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = 20;
        $num_ai=50;
        $num_pigeons_per_ai = 100;   
        for ($level = 1; $level <= $levels; $level++) {
            $this->command->info("Seeding Level $level");
            
            for ($i = 1; $i <= $num_ai; $i++) {
                $aiUser = User::factory()->create([
                    'name' => "AI Level $level - $i",
                    'is_ai' => true
                ]);

                $aiLoft = Loft::create([
                    'user_id' => $aiUser->id,
                    'name' => "AI Loft L$level - $i",
                    'coins' => 10000,
                    'vitamins' => 1000,
                    'level' => $level,
                ]);

                $pigeonsData = [];
                for ($j = 0; $j < $num_pigeons_per_ai; $j++) {
                    $pigeonLevel = rand(1, $level);
                    $intelligence = rand(1, 100);

                    $rarity = match (true) {
                        $intelligence >= 95 => 'mythic',
                        $intelligence >= 80 => 'legendary',
                        $intelligence >= 60 => 'super_rare',
                        $intelligence >= 40 => 'rare',
                        default => 'common',
                    };

                    $pigeonsData[] = [
                        'loft_id' => $aiLoft->id,
                        'name' => "AI Bird " . fake()->word() . rand(1, 9999),
                        'level' => $pigeonLevel,
                        'intelligence' => $intelligence,
                        'rarity' => $rarity,
                        'type' => fake()->randomElement(['fancy', 'racer', 'highflyer']),
                        'gender' => fake()->randomElement(['male', 'female']),
                        'birth_at' => now()->subDays(10),
                        'hatch_at' => now()->subDays(6),
                        'eyes' => rand(1, $pigeonLevel * 10),
                        'beak' => rand(1, $pigeonLevel * 10),
                        'legs' => rand(1, $pigeonLevel * 10),
                        'feather_quality' => rand(1, $pigeonLevel * 10),
                        'pattern' => rand(1, $pigeonLevel * 10),
                        'color' => rand(1, $pigeonLevel * 10),
                        'purity' => rand(1, $pigeonLevel * 10),
                        'speed' => rand(1, $pigeonLevel * 10),
                        'endurance' => rand(1, $pigeonLevel * 10),
                        'navigation' => rand(1, $pigeonLevel * 10),
                        'temperament' => rand(1, $pigeonLevel * 10),
                        'loyalty' => 0,
                        'energy' => 100,
                        'status' => 'idle',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                
                // Bulk insert pigeons
                Pigeon::insert($pigeonsData);

                // List some pigeons
                $aiLoft->pigeons()->inRandomOrder()->limit(2)->each(function ($p) {
                    $price = rand($p->level * 900, $p->level * 1100);
                    Listing::create([
                        'loft_id' => $p->loft_id,
                        'pigeon_id' => $p->id,
                        'price' => $price,
                        'expires_at' => now()->addDay(),
                        'is_active' => true,
                    ]);
                    $p->update(['status' => 'for_sale']);
                });
            }
        }

        // 3. Create Races & FAQs
        // Seeding some FAQs
        FAQ::insert([
            ['question' => 'How to race?', 'answer' => 'Go to the Race lobby and join a race.'],
            ['question' => 'How to breed?', 'answer' => 'Visit the Breeding Center with two adult pigeons.'],
        ]);
        
        // Seeding some Races (placeholder logic)
        Race::insert([
            ['title' => 'Exibition', 'race_type' => 'exhibition', 'distance_km' => 100],
            ['title' => 'Highflyer Challenge', 'race_type' => 'highflyer', 'distance_km' => 1000],
            ['title' => 'Marathon Cup', 'race_type' => 'racing', 'distance_km' => 1000],
        ]);
    }
}
