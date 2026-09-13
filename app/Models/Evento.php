<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evento extends Model
{
    protected $table = 'eventos';

    protected $fillable = [
        'categoria_evento_id',
        'usuario_id',
        'titulo',
        'descricao',
        'local',
        'data_evento',
        'horario_inicio',
        'horario_fim',
        'max_participantes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'data_evento' => 'date',
            'max_participantes' => 'integer',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(
            CategoriaEvento::class,
            'categoria_evento_id'
        );
    }

    public function organizador(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'usuario_id'
        );
    }
}