<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::query()->firstOrCreate(
            ['name' => 'Palestra'],
            ['description' => 'Apresentações e conferências.'],
        );

        Category::query()->firstOrCreate(
            ['name' => 'Workshop'],
            ['description' => 'Atividades práticas guiadas.'],
        );

        Category::query()->firstOrCreate(
            ['name' => 'Show'],
            ['description' => 'Apresentações culturais e musicais.'],
        );
    }
}
