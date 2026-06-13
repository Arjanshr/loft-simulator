<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Loft;
use App\Models\Pigeon;
use App\Models\Race;
use App\Models\FAQ;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Test User and Loft
        $user = User::firstOrCreate([
            'email' => 'pro@pigeon.com',
        ], [
            'name' => 'Pro Racer',
            'password' => bcrypt('password'),
        ]);

        // Ensure loft exists for the user
        $loft = Loft::firstOrCreate([
            'user_id' => $user->id,
        ], [
            'name' => 'Victory Loft',
            'coins' => 5000,
            'level' => 10,
            'xp' => 0,
        ]);

        // Adult Male
        Pigeon::create([
            'loft_id' => $loft->id,
            'name' => "Sire",
            'level' => 1,
            'type' => 'fancy',
            'gender' => 'male',
            'birth_at' => now()->subDays(10),
            'hatch_at' => now()->subDays(6),
            'eyes' => 1, 'beak' => 1, 'legs' => 1, 'feather_quality' => 1, 'pattern' => 1, 'color' => 1, 'purity' => 1,
            'rarity' => 'common',
            'speed' => 5, 'endurance' => 5, 'navigation' => 5, 'temperament' => 5,
            'energy' => 100, 'status' => 'idle',
        ]);

        // Adult Female
        Pigeon::create([
            'loft_id' => $loft->id,
            'name' => "Dam",
            'level' => 1,
            'type' => 'fancy',
            'gender' => 'female',
            'birth_at' => now()->subDays(10),
            'hatch_at' => now()->subDays(6),
            'eyes' => 1, 'beak' => 1, 'legs' => 1, 'feather_quality' => 1, 'pattern' => 1, 'color' => 1, 'purity' => 1,
            'rarity' => 'common',
            'speed' => 5, 'endurance' => 5, 'navigation' => 5, 'temperament' => 5,
            'energy' => 100, 'status' => 'idle',
        ]);

        // Juvenile
        Pigeon::create([
            'loft_id' => $loft->id,
            'name' => "Chick",
            'level' => 1,
            'type' => 'fancy',
            'gender' => 'male',
            'birth_at' => now()->subDays(2),
            'hatch_at' => now()->subDays(1),
            'eyes' => 1, 'beak' => 1, 'legs' => 1, 'feather_quality' => 1, 'pattern' => 1, 'color' => 1, 'purity' => 1,
            'rarity' => 'common',
            'speed' => 5, 'endurance' => 5, 'navigation' => 5, 'temperament' => 5,
            'energy' => 100, 'status' => 'idle',
        ]);

        // 2. Create 100 AI Lofts and Pigeons
        for ($i = 1; $i <= 100; $i++) {
            $aiUser = User::factory()->create([
                'name' => "AI Trainer $i",
                'is_ai' => true
            ]);
            $level = rand(1, 100);
            $aiLoft = Loft::create([
                'user_id' => $aiUser->id,
                'name' => "AI Loft $i",
                'coins' => 1000,
                'level' => $level,
            ]);

            Pigeon::create([
                'loft_id' => $aiLoft->id,
                'name' => "AI Bird " . rand(1, 1000),
                'level' => $level,
                'type' => fake()->randomElement(['fancy', 'racer', 'highflyer']),
                'gender' => fake()->randomElement(['male', 'female']),
                'birth_at' => now()->subDays(10), // Ensure they are adults
                'hatch_at' => now()->subDays(6),
                'eyes' => rand(1, $level * 10),
                'beak' => rand(1, $level * 10),
                'legs' => rand(1, $level * 10),
                'feather_quality' => rand(1, $level * 10),
                'pattern' => rand(1, $level * 10),
                'color' => rand(1, $level * 10),
                'purity' => rand(1, $level * 10),
                'rarity' => fake()->randomElement(['common', 'rare', 'legendary']),
                'speed' => rand(1, $level * 10),
                'endurance' => rand(1, $level * 10),
                'navigation' => rand(1, $level * 10),
                'temperament' => rand(1, $level * 10),
                'energy' => 100,
                'status' => 'idle',
            ]);
        }

        // 3. Create Races
        Race::create([
            'title' => 'Beginner Exhibition',
            'distance_km' => 50,
            'difficulty_tier' => 1,
            'entry_fee' => 50,
            'prize_pool' => 500,
            'race_type' => 'exhibition',
            'level_requirement' => 1,
        ]);

        Race::create([
            'title' => 'Pro Racing Cup',
            'distance_km' => 300,
            'difficulty_tier' => 2,
            'entry_fee' => 200,
            'prize_pool' => 2000,
            'race_type' => 'racing',
            'level_requirement' => 5,
        ]);

        Race::create([
            'title' => 'Sky High Tournament',
            'distance_km' => 200,
            'difficulty_tier' => 3,
            'entry_fee' => 500,
            'prize_pool' => 5000,
            'race_type' => 'highflyer',
            'level_requirement' => 5,
        ]);

        // 4. Create FAQs
        FAQ::create([
            'question' => 'How do I train my pigeons?',
            'answer' => 'Go to the Loft Dashboard, find the Pigeon Manager, and click the "Train" button on the stat you want to improve.',
            'category' => 'Gameplay',
            'order' => 1
        ]);
        FAQ::create([
            'question' => 'How do I upgrade my loft?',
            'answer' => 'When your loft has enough XP and Coins, an "Upgrade Loft" button will appear on your dashboard header.',
            'category' => 'Progression',
            'order' => 2
        ]);
        FAQ::create([
            'question' => 'How does breeding work?',
            'answer' => 'In the Breeding Center, you can pair one male and one female adult pigeon (4+ days old) if you have an available breeding cage. Once paired, you can initiate breeding, which starts an incubation period.',
            'category' => 'Breeding',
            'order' => 3
        ]);
        FAQ::create([
            'question' => 'How many breeding cages do I have?',
            'answer' => 'Your breeding cage capacity is equal to your loft level. Upgrade your loft to unlock more cages.',
            'category' => 'Breeding',
            'order' => 4
        ]);
        FAQ::create([
            'question' => 'How does energy work?',
            'answer' => 'Pigeons in idle status recover 5% energy per hour. You can also spend 50 coins to instantly fully rest a pigeon.',
            'category' => 'Pigeon Care',
            'order' => 5
        ]);
        FAQ::create([
            'question' => 'Can I rename my pigeons?',
            'answer' => 'Yes! In the Pigeon Manager, you can edit the pigeon\'s name and click "Rename" to update it.',
            'category' => 'Pigeon Care',
            'order' => 6
        ]);
        FAQ::create([
            'question' => 'Where can I see my activity history?',
            'answer' => 'You can view a full history of your loft\'s activities, such as training, breeding, and marketplace sales, in the Activity Log page.',
            'category' => 'General',
            'order' => 7
        ]);
    }
}
