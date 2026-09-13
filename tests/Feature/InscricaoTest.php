<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\CategoriaEvento;
use App\Models\Evento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InscricaoTest extends TestCase
{
    use RefreshDatabase;

    public function test_participante_pode_se_inscrever_em_evento_ativo(): void
    {
        $participante = User::factory()->create(['role' => UserRole::Participant]);
        $evento = $this->criarEvento();

        $this->actingAs($participante)
            ->post(route('inscricoes.store', $evento))
            ->assertRedirect(route('eventos.show', $evento));

        $this->assertDatabaseHas('inscricoes', [
            'evento_id' => $evento->id,
            'usuario_id' => $participante->id,
            'status' => 'confirmada',
        ]);
    }

    private function criarEvento(array $atributos = []): Evento
    {
        $organizador = User::factory()->create(['role' => UserRole::Organizer]);
        $categoria = CategoriaEvento::query()->create(['nome' => 'Tecnologia']);

        return Evento::query()->create(array_merge([
            'categoria_evento_id' => $categoria->id,
            'usuario_id' => $organizador->id,
            'titulo' => 'Encontro Laravel',
            'descricao' => 'Evento para estudar Laravel.',
            'local' => 'Laboratório 1',
            'data_evento' => now()->addWeek()->toDateString(),
            'horario_inicio' => '19:00',
            'horario_fim' => '21:00',
            'max_participantes' => 20,
            'status' => 'ativo',
        ], $atributos));
    }
}
