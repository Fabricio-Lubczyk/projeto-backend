<?php

namespace Tests\Feature;

use App\Models\CategoriaEvento;
use App\Models\Evento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'session.driver' => 'array',
        ]);
    }

    public function test_usuario_autenticado_pode_criar_evento(): void
    {
        $usuario = User::factory()->create();

        $categoria = CategoriaEvento::create([
            'nome' => 'Esportes',
            'descricao' => 'Eventos esportivos.',
        ]);

        $dados = [
            'categoria_evento_id' => $categoria->id,
            'titulo' => 'Torneio de Vôlei',
            'descricao' => 'Torneio universitário de vôlei.',
            'local' => 'Ginásio',
            'data_evento' => now()->addDays(5)->toDateString(),
            'horario_inicio' => '18:00',
            'horario_fim' => '21:00',
            'max_participantes' => 50,
            'status' => 'ativo',
        ];

        $resposta = $this
            ->actingAs($usuario)
            ->post(route('eventos.store'), $dados);

        $resposta->assertRedirect(route('eventos.index'));

        $this->assertDatabaseHas('eventos', [
            'titulo' => 'Torneio de Vôlei',
            'usuario_id' => $usuario->id,
            'categoria_evento_id' => $categoria->id,
        ]);
    }

    public function test_organizador_pode_editar_seu_evento(): void
    {
        $usuario = User::factory()->create();

        $categoria = CategoriaEvento::create([
            'nome' => 'Tecnologia',
            'descricao' => 'Eventos de tecnologia.',
        ]);

        $evento = Evento::create([
            'categoria_evento_id' => $categoria->id,
            'usuario_id' => $usuario->id,
            'titulo' => 'Evento Antigo',
            'descricao' => 'Descrição antiga.',
            'local' => 'Sala 1',
            'data_evento' => now()->addDays(10)->toDateString(),
            'horario_inicio' => '14:00',
            'horario_fim' => '17:00',
            'max_participantes' => 30,
            'status' => 'ativo',
        ]);

        $dados = [
            'categoria_evento_id' => $categoria->id,
            'titulo' => 'Evento Atualizado',
            'descricao' => 'Descrição atualizada.',
            'local' => 'Auditório',
            'data_evento' => now()->addDays(15)->toDateString(),
            'horario_inicio' => '15:00',
            'horario_fim' => '18:00',
            'max_participantes' => 60,
            'status' => 'ativo',
        ];

        $resposta = $this
            ->actingAs($usuario)
            ->put(route('eventos.update', $evento), $dados);

        $resposta->assertRedirect(
            route('eventos.show', $evento)
        );

        $this->assertDatabaseHas('eventos', [
            'id' => $evento->id,
            'titulo' => 'Evento Atualizado',
            'local' => 'Auditório',
            'max_participantes' => 60,
        ]);
    }

    public function test_usuario_nao_pode_editar_evento_de_outro_usuario(): void
    {
        $organizador = User::factory()->create();
        $outroUsuario = User::factory()->create();

        $categoria = CategoriaEvento::create([
            'nome' => 'Acadêmico',
            'descricao' => 'Eventos acadêmicos.',
        ]);

        $evento = Evento::create([
            'categoria_evento_id' => $categoria->id,
            'usuario_id' => $organizador->id,
            'titulo' => 'Semana Acadêmica',
            'descricao' => 'Evento acadêmico.',
            'local' => 'Auditório',
            'data_evento' => now()->addDays(10)->toDateString(),
            'horario_inicio' => '19:00',
            'horario_fim' => '22:00',
            'max_participantes' => 100,
            'status' => 'ativo',
        ]);

        $resposta = $this
            ->actingAs($outroUsuario)
            ->get(route('eventos.edit', $evento));

        $resposta->assertForbidden();
    }

    public function test_organizador_pode_excluir_seu_evento(): void
    {
        $usuario = User::factory()->create();

        $categoria = CategoriaEvento::create([
            'nome' => 'Cultural',
            'descricao' => 'Eventos culturais.',
        ]);

        $evento = Evento::create([
            'categoria_evento_id' => $categoria->id,
            'usuario_id' => $usuario->id,
            'titulo' => 'Evento Cultural',
            'descricao' => 'Evento para teste.',
            'local' => 'Centro Cultural',
            'data_evento' => now()->addDays(20)->toDateString(),
            'horario_inicio' => '18:00',
            'horario_fim' => '20:00',
            'max_participantes' => 80,
            'status' => 'ativo',
        ]);

        $resposta = $this
            ->actingAs($usuario)
            ->delete(route('eventos.destroy', $evento));

        $resposta->assertRedirect(route('eventos.index'));

        $this->assertDatabaseMissing('eventos', [
            'id' => $evento->id,
        ]);
    }
    public function test_nao_permite_evento_com_data_passada(): void
{
    $usuario = User::factory()->create();

    $categoria = CategoriaEvento::create([
        'nome' => 'Esportes',
        'descricao' => 'Eventos esportivos.',
    ]);

    $dados = [
        'categoria_evento_id' => $categoria->id,
        'titulo' => 'Evento com Data Passada',
        'descricao' => 'Teste de validação.',
        'local' => 'Ginásio',
        'data_evento' => now()->subDay()->toDateString(),
        'horario_inicio' => '18:00',
        'horario_fim' => '20:00',
        'max_participantes' => 50,
        'status' => 'ativo',
    ];

    $resposta = $this
        ->actingAs($usuario)
        ->post(route('eventos.store'), $dados);

    $resposta->assertSessionHasErrors('data_evento');

    $this->assertDatabaseMissing('eventos', [
        'titulo' => 'Evento com Data Passada',
    ]);
}

public function test_nao_permite_horario_final_anterior_ao_inicial(): void
{
    $usuario = User::factory()->create();

    $categoria = CategoriaEvento::create([
        'nome' => 'Tecnologia',
        'descricao' => 'Eventos de tecnologia.',
    ]);

    $dados = [
        'categoria_evento_id' => $categoria->id,
        'titulo' => 'Evento Horário Inválido',
        'descricao' => 'Teste de horários.',
        'local' => 'Laboratório',
        'data_evento' => now()->addDays(5)->toDateString(),
        'horario_inicio' => '18:00',
        'horario_fim' => '15:00',
        'max_participantes' => 30,
        'status' => 'ativo',
    ];

    $resposta = $this
        ->actingAs($usuario)
        ->post(route('eventos.store'), $dados);

    $resposta->assertSessionHasErrors('horario_fim');

    $this->assertDatabaseMissing('eventos', [
        'titulo' => 'Evento Horário Inválido',
    ]);
}

public function test_nao_permite_evento_sem_participantes(): void
{
    $usuario = User::factory()->create();

    $categoria = CategoriaEvento::create([
        'nome' => 'Acadêmico',
        'descricao' => 'Eventos acadêmicos.',
    ]);

    $dados = [
        'categoria_evento_id' => $categoria->id,
        'titulo' => 'Evento Sem Participantes',
        'descricao' => 'Teste de participantes.',
        'local' => 'Auditório',
        'data_evento' => now()->addDays(5)->toDateString(),
        'horario_inicio' => '19:00',
        'horario_fim' => '22:00',
        'max_participantes' => 0,
        'status' => 'ativo',
    ];

    $resposta = $this
        ->actingAs($usuario)
        ->post(route('eventos.store'), $dados);

    $resposta->assertSessionHasErrors('max_participantes');

    $this->assertDatabaseMissing('eventos', [
        'titulo' => 'Evento Sem Participantes',
    ]);
}

public function test_nao_permite_status_invalido(): void
{
    $usuario = User::factory()->create();

    $categoria = CategoriaEvento::create([
        'nome' => 'Cultural',
        'descricao' => 'Eventos culturais.',
    ]);

    $dados = [
        'categoria_evento_id' => $categoria->id,
        'titulo' => 'Evento Status Inválido',
        'descricao' => 'Teste de status.',
        'local' => 'Centro Cultural',
        'data_evento' => now()->addDays(5)->toDateString(),
        'horario_inicio' => '18:00',
        'horario_fim' => '21:00',
        'max_participantes' => 100,
        'status' => 'qualquer_coisa',
    ];

    $resposta = $this
        ->actingAs($usuario)
        ->post(route('eventos.store'), $dados);

    $resposta->assertSessionHasErrors('status');

    $this->assertDatabaseMissing('eventos', [
        'titulo' => 'Evento Status Inválido',
    ]);
}
}