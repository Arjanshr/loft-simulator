<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Loft;
use App\Models\Pigeon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $user = User::firstOrCreate([
            'email' => 'sirarjan@gmail.com',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('Nirvana2042'),
            'is_admin' => true,
        ]);

        $loft = Loft::firstOrCreate([
            'user_id' => $user->id,
        ], [
            'name' => 'Admin Loft',
            'coins' => 99999,
            'vitamins' => 99999,
            'level' => 1,
            'xp' => 0,
        ]);

        // Starter pigeons
        $pigeonService = new \App\Services\PigeonService();
        $pigeonService->createAdult($loft, 'Sire', 'male');
        $pigeonService->createAdult($loft, 'Dam', 'female');
        $pigeonService->createJuvenile($loft, 'Chick');

        // 2. Call MassDataSeeder
        $this->call([
            MassDataSeeder::class,
        ]);
    }
}
