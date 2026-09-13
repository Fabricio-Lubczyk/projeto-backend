<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\CategoriaEvento;
use App\Models\Evento;
use App\Models\Inscricao;
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

    public function test_participante_nao_pode_realizar_duas_inscricoes_no_mesmo_evento(): void
    {
        $participante = User::factory()->create(['role' => UserRole::Participant]);
        $evento = $this->criarEvento();

        $this->actingAs($participante)->post(route('inscricoes.store', $evento));

        $this->actingAs($participante)
            ->from(route('eventos.show', $evento))
            ->post(route('inscricoes.store', $evento))
            ->assertRedirect(route('eventos.show', $evento))
            ->assertSessionHasErrors('evento');

        $this->assertDatabaseCount('inscricoes', 1);
    }

    public function test_participante_nao_pode_se_inscrever_quando_nao_ha_vagas(): void
    {
        $primeiroParticipante = User::factory()->create(['role' => UserRole::Participant]);
        $segundoParticipante = User::factory()->create(['role' => UserRole::Participant]);
        $evento = $this->criarEvento(['max_participantes' => 1]);

        $this->actingAs($primeiroParticipante)->post(route('inscricoes.store', $evento));

        $this->actingAs($segundoParticipante)
            ->from(route('eventos.show', $evento))
            ->post(route('inscricoes.store', $evento))
            ->assertRedirect(route('eventos.show', $evento))
            ->assertSessionHasErrors('evento');

        $this->assertDatabaseCount('inscricoes', 1);
    }

    public function test_participante_pode_cancelar_a_propria_inscricao(): void
    {
        $participante = User::factory()->create(['role' => UserRole::Participant]);
        $evento = $this->criarEvento();
        $inscricao = Inscricao::query()->create([
            'evento_id' => $evento->id,
            'usuario_id' => $participante->id,
            'status' => 'confirmada',
        ]);

        $this->actingAs($participante)
            ->delete(route('inscricoes.destroy', $inscricao))
            ->assertRedirect(route('inscricoes.minhas'));

        $this->assertDatabaseHas('inscricoes', [
            'id' => $inscricao->id,
            'status' => 'cancelada',
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
