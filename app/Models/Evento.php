<?php

namespace App\Models;

use App\Policies\EventoPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UsePolicy(EventoPolicy::class)]
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

    public function inscricoes(): HasMany
    {
        return $this->hasMany(Inscricao::class, 'evento_id');
    }

    public function inscricoesConfirmadas(): HasMany
    {
        return $this->inscricoes()->where('status', 'confirmada');
    }

    public function possuiVagas(): bool
    {
        return $this->vagasRestantes() > 0;
    }

    public function vagasRestantes(): int
    {
        return max(0, $this->max_participantes - $this->inscricoesConfirmadas()->count());
    }
}
