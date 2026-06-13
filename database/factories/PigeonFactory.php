<?php

namespace Database\Factories;

use App\Models\Pigeon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pigeon>
 */
class PigeonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['fancy', 'racer', 'highflyer'];
        $rarities = ['common', 'rare', 'legendary'];
        
        return [
            'name' => fake()->name(),
            'level' => rand(1, 10),
            'type' => fake()->randomElement($types),
            'gender' => fake()->randomElement(['male', 'female']),
            'eyes' => rand(1, 100),
            'beak' => rand(1, 100),
            'legs' => rand(1, 100),
            'feather_quality' => rand(1, 100),
            'pattern' => rand(1, 100),
            'color' => rand(1, 100),
            'purity' => rand(1, 100),
            'rarity' => fake()->randomElement($rarities),
            'speed' => rand(1, 100),
            'endurance' => rand(1, 100),
            'navigation' => rand(1, 100),
            'temperament' => rand(1, 100),
            'energy' => 100,
            'status' => 'idle',
        ];
    }
}
