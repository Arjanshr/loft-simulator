<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        FAQ::truncate();

        $data = [
            // Loft Management
            [
                'category' => 'Loft Management',
                'question' => 'How do I level up my Loft?',
                'answer' => 'Your Loft gains Experience Points (XP) through tournament participation and podium finishes. Once you have enough XP, an "Upgrade" button will appear on your Dashboard. XP Required = Level² * 100. Upgrading costs (Level * 500) coins.',
            ],
            [
                'category' => 'Loft Management',
                'question' => 'What is the limit of birds in my Loft?',
                'answer' => 'The number of birds you can hold is limited by your Loft Level. Higher levels allow for more active breeding cages and larger flock sizes.',
            ],

            // Pigeon Mastery
            [
                'category' => 'Pigeon Mastery',
                'question' => 'How do I rank up my pigeons?',
                'answer' => 'To promote a pigeon to the next level, it must reach a Training Milestone. Total stat points (Speed + Endurance + Navigation + Temperament) must be at least (Current Level * 30). Note: A pigeon cannot rank up higher than your current Loft Level.',
            ],
            [
                'category' => 'Pigeon Mastery',
                'question' => 'What do the different stats mean?',
                'answer' => 'Speed: Influences performance in Racing. Endurance: Crucial for Highflyer and Racing events. Navigation: Key for Highflyer and finding the way home. Temperament: General consistency. Intelligence: Affects learning rate and race precision.',
            ],
            [
                'category' => 'Pigeon Mastery',
                'question' => 'How does Condition (Energy) work?',
                'answer' => 'Birds consume energy during training and racing. "Idle" birds recover 5% energy per hour. You can also perform an "Instant Rest" for 50 coins to refill energy to 100%.',
            ],

            // Breeding & Heredity
            [
                'category' => 'Breeding & Heredity',
                'question' => 'How long does it take for eggs to hatch?',
                'answer' => 'Successful pairing produces eggs after 6 hours. Incubation takes 24 hours. The hatchling then progresses through Juvenile (Day 2) and Yearling (Day 3) stages before becoming an Adult on Day 4.',
            ],
            [
                'category' => 'Breeding & Heredity',
                'question' => 'How are stats inherited by offspring?',
                'answer' => 'Offspring stats are calculated as a random value between the minimum and maximum of the two parents\' corresponding attributes. Selective breeding of high-stat parents is the key to superior bloodlines.',
            ],
            [
                'category' => 'Breeding & Heredity',
                'question' => 'What is the Beauty Score?',
                'answer' => 'The Appearance Grade (Beauty Score) is the average of 7 aesthetic sub-attributes: Eyes, Beak, Legs, Feathering, Pattern, Color, and Bloodline Purity. This score is vital for Exhibition tournaments and passive income.',
            ],

            // Economy & The Exchange
            [
                'category' => 'Economy & The Exchange',
                'question' => 'How do I earn coins?',
                'answer' => 'Coins are earned via: 1. Tournament prizes. 2. Leveling up pigeons (100 * New Level). 3. Selling birds in the Exchange. 4. Passive income from "Fancy" strain birds.',
            ],
            [
                'category' => 'Economy & The Exchange',
                'question' => 'How is passive income calculated?',
                'answer' => 'Fancy pigeons generate income every minute. Formula: 1 Base Coin + (Beauty Score / 10). A high-grade Fancy bird can provide a significant reserve fund for your loft operations.',
            ],
            [
                'category' => 'Economy & The Exchange',
                'question' => 'Why can\'t I see high-level birds in the Exchange?',
                'answer' => 'The Exchange Registry (Marketplace) follows strict protocol. You can only view and purchase specimens that are at most (Your Loft Level + 1). Higher-level lofts have access to more elite genetic stock.',
            ],
            [
                'category' => 'Economy & The Exchange',
                'question' => 'How long do auctions last?',
                'answer' => 'All listings in the Exchange are time-limited to 24 hours. If a bird isn\'t purchased within this window, the auction expires and the bird returns to the owner\'s registry.',
            ],

            // Lost Birds & Strays
            [
                'category' => 'Lost Birds & Strays',
                'question' => 'Can my birds get lost?',
                'answer' => 'Yes. Pigeons with low Loyalty (< 20%) have a chance to get lost during training or racing. Lost birds move between random lofts every hour.',
            ],
            [
                'category' => 'Lost Birds & Strays',
                'question' => 'How do I catch stray birds?',
                'answer' => 'Check your Loft Dashboard for "Stray Detection". If a lost bird is currently at your loft, you can attempt to capture it. Successful capture adds the bird to your registry, but remember: birds auto-return to their original owners after 24 hours if not captured.',
            ],
        ];

        foreach ($data as $index => $faq) {
            FAQ::create(array_merge($faq, ['order' => $index]));
        }
    }
}
