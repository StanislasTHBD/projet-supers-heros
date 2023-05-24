<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Incidents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'test@gmail.com',
            'password' => bcrypt('test'),
            'role' => 'admin',
        ]);

        $incidents = [
            'Incendie',
            'Accident routier',
            'Accident fluvial',
            'Accident aérien',
            'Éboulement',
            'Invasion de serpent',
            'Fuite de gaz',
            'Manifestation',
            'Braquage',
            'Évasion d’un prisonnier'
        ];

        foreach ($incidents as $incident) {
            Incidents::create([
                'name' => $incident,
            ]);
        }
    }
}
