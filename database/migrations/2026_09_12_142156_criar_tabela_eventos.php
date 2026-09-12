<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('categoria_evento_id')
                ->constrained('categorias_eventos');

            $table->foreignId('usuario_id')
                ->constrained('users');

            $table->string('titulo');
            $table->text('descricao');
            $table->string('local');
            $table->date('data_evento');
            $table->time('horario_inicio');
            $table->time('horario_fim');
            $table->unsignedInteger('max_participantes');
            $table->string('status')->default('ativo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};