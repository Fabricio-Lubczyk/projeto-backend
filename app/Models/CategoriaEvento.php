<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoriaEvento extends Model
{
    protected $table = 'categorias_eventos';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class, 'categoria_evento_id');
    }
}