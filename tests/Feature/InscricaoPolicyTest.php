<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Evento;
use App\Models\Inscricao;
use App\Models\User;
use App\Policies\InscricaoPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InscricaoPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_apenas_organizador_do_evento_pode_ver_participantes(): void
    {
        $organizador = User::factory()->create(['role' => UserRole::Organizer]);
        $outroUsuario = User::factory()->create(['role' => UserRole::Participant]);
        $evento = new Evento(['usuario_id' => $organizador->id]);
        $policy = new InscricaoPolicy;

        $this->assertTrue($policy->viewParticipants($organizador, $evento));
        $this->assertFalse($policy->viewParticipants($outroUsuario, $evento));
    }

    public function test_participante_pode_cancelar_somente_a_propria_inscricao(): void
    {
        $participante = User::factory()->create(['role' => UserRole::Participant]);
        $outroParticipante = User::factory()->create(['role' => UserRole::Participant]);
        $inscricao = new Inscricao(['usuario_id' => $participante->id]);
        $policy = new InscricaoPolicy;

        $this->assertTrue($policy->delete($participante, $inscricao));
        $this->assertFalse($policy->delete($outroParticipante, $inscricao));
    }
}
