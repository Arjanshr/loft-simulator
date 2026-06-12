<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Race;
use App\Models\Pigeon;
use App\Models\Loft;
use App\Models\User;
use App\Services\RaceSimulationService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RaceSimulationTest extends TestCase
{
    use RefreshDatabase;

    public function test_race_simulation_produces_results()
    {
        // 1. Setup
        $user = User::factory()->create();
        $loft = Loft::create(['user_id' => $user->id, 'name' => 'Test Loft']);
        $pigeons = collect();
        
        for ($i = 0; $i < 5; $i++) {
            $pigeons->push(Pigeon::create([
                'loft_id' => $loft->id,
                'name' => "Bird $i",
                'speed' => rand(10, 50),
                'endurance' => rand(10, 50),
                'navigation' => rand(10, 50),
                'temperament' => rand(10, 50),
            ]));
        }

        $race = Race::create([
            'title' => 'Test Race',
            'distance_km' => 100,
            'prize_pool' => 1000,
        ]);

        // 2. Execute
        $service = new RaceSimulationService();
        $results = $service->simulate($race, $pigeons);

        // 3. Assert
        $this->assertCount(5, $results);
        $this->assertEquals(1, $results->first()->position);
        $this->assertEquals(5, $results->last()->position);
        $this->assertGreaterThan(0, $results->first()->payout);
        $this->assertEquals(0, $results->last()->payout);
        
        // Check if loft coins updated (60% of 1000 = 600)
        $this->assertEquals(1000 + 600 + 250 + 100, $loft->fresh()->coins); // 1st, 2nd, 3rd payouts
    }
}
