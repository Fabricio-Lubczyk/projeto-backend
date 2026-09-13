<?php

namespace Database\Seeders;

use App\Models\CategoriaEvento;
use Illuminate\Database\Seeder;

class CategoriaEventoSeeder extends Seeder
{
    public function run(): void
    {
        CategoriaEvento::firstOrCreate(
            ['nome' => 'Esportes'],
            ['descricao' => 'Eventos esportivos e competições.']
        );

        CategoriaEvento::firstOrCreate(
            ['nome' => 'Acadêmico'],
            ['descricao' => 'Palestras, cursos e eventos acadêmicos.']
        );

        CategoriaEvento::firstOrCreate(
            ['nome' => 'Tecnologia'],
            ['descricao' => 'Eventos relacionados à tecnologia e inovação.']
        );

        CategoriaEvento::firstOrCreate(
            ['nome' => 'Cultural'],
            ['descricao' => 'Eventos culturais, artísticos e sociais.']
        );

        CategoriaEvento::firstOrCreate(
            ['nome' => 'Entretenimento'],
            ['descricao' => 'Eventos de lazer e entretenimento.']
        );
    }
}