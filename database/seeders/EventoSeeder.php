<?php

namespace Database\Seeders;

use App\Models\CategoriaEvento;
use App\Models\Evento;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $usuario = User::first();

        if (!$usuario) {
            $this->command?->warn(
                'Nenhum usuário encontrado. Os eventos não foram criados.'
            );

            return;
        }

        $categoriaEsportes = CategoriaEvento::where(
            'nome',
            'Esportes'
        )->first();

        $categoriaAcademico = CategoriaEvento::where(
            'nome',
            'Acadêmico'
        )->first();

        $categoriaTecnologia = CategoriaEvento::where(
            'nome',
            'Tecnologia'
        )->first();

        if (
            !$categoriaEsportes ||
            !$categoriaAcademico ||
            !$categoriaTecnologia
        ) {
            $this->command?->warn(
                'Execute o CategoriaEventoSeeder antes do EventoSeeder.'
            );

            return;
        }

        Evento::firstOrCreate(
            [
                'titulo' => 'Torneio Universitário de Vôlei',
            ],
            [
                'categoria_evento_id' => $categoriaEsportes->id,
                'usuario_id' => $usuario->id,
                'descricao' => 'Torneio de vôlei entre equipes universitárias.',
                'local' => 'Ginásio Principal',
                'data_evento' => now()->addDays(7)->toDateString(),
                'horario_inicio' => '18:00',
                'horario_fim' => '22:00',
                'max_participantes' => 100,
                'status' => 'ativo',
            ]
        );

        Evento::firstOrCreate(
            [
                'titulo' => 'Semana Acadêmica',
            ],
            [
                'categoria_evento_id' => $categoriaAcademico->id,
                'usuario_id' => $usuario->id,
                'descricao' => 'Palestras e atividades acadêmicas para os estudantes.',
                'local' => 'Auditório da Faculdade',
                'data_evento' => now()->addDays(15)->toDateString(),
                'horario_inicio' => '19:00',
                'horario_fim' => '22:00',
                'max_participantes' => 200,
                'status' => 'ativo',
            ]
        );

        Evento::firstOrCreate(
            [
                'titulo' => 'Workshop de Desenvolvimento Web',
            ],
            [
                'categoria_evento_id' => $categoriaTecnologia->id,
                'usuario_id' => $usuario->id,
                'descricao' => 'Workshop introdutório sobre desenvolvimento web.',
                'local' => 'Laboratório de Informática',
                'data_evento' => now()->addDays(25)->toDateString(),
                'horario_inicio' => '14:00',
                'horario_fim' => '18:00',
                'max_participantes' => 40,
                'status' => 'ativo',
            ]
        );
    }
}