<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\CategoriaEvento;
use App\Models\Evento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventoPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_participante_nao_pode_criar_evento(): void
    {
        $participante = User::factory()->create(['role' => UserRole::Participant]);
        $categoria = CategoriaEvento::query()->create(['nome' => 'Tecnologia']);

        $this->actingAs($participante)
            ->post(route('eventos.store'), $this->dadosEvento($categoria))
            ->assertForbidden();
    }

    public function test_administrador_pode_editar_evento_de_outro_organizador(): void
    {
        $organizador = User::factory()->create(['role' => UserRole::Organizer]);
        $administrador = User::factory()->create(['role' => UserRole::Admin]);
        $categoria = CategoriaEvento::query()->create(['nome' => 'Acadêmico']);
        $evento = Evento::query()->create($this->dadosEvento($categoria) + [
            'usuario_id' => $organizador->id,
        ]);

        $this->actingAs($administrador)
            ->get(route('eventos.edit', $evento))
            ->assertOk();
    }

    private function dadosEvento(CategoriaEvento $categoria): array
    {
        return [
            'categoria_evento_id' => $categoria->id,
            'titulo' => 'Evento de teste',
            'descricao' => 'Descrição do evento de teste.',
            'local' => 'Auditório',
            'data_evento' => now()->addWeek()->toDateString(),
            'horario_inicio' => '18:00',
            'horario_fim' => '20:00',
            'max_participantes' => 30,
            'status' => 'ativo',
        ];
    }
}
