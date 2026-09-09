<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Venue::query()->firstOrCreate(
            ['name' => 'Auditório Central'],
            [
                'address' => 'Bloco A, térreo',
                'capacity' => 180,
            ],
        );

        Venue::query()->firstOrCreate(
            ['name' => 'Sala Multiuso'],
            [
                'address' => 'Bloco B, sala 12',
                'capacity' => 60,
            ],
        );
    }
}
