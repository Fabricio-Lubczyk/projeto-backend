<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AtualizarEventoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoria_evento_id' => [
                'required',
                'exists:categorias_eventos,id',
            ],

            'titulo' => [
                'required',
                'string',
                'max:255',
            ],

            'descricao' => [
                'required',
                'string',
            ],

            'local' => [
                'required',
                'string',
                'max:255',
            ],

            'data_evento' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'horario_inicio' => [
                'required',
                'date_format:H:i',
            ],

            'horario_fim' => [
                'required',
                'date_format:H:i',
                'after:horario_inicio',
            ],

            'max_participantes' => [
                'required',
                'integer',
                'min:1',
            ],

            'status' => [
                'required',
                Rule::in([
                    'ativo',
                    'inativo',
                    'cancelado',
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'categoria_evento_id.required' => 'Selecione uma categoria.',
            'categoria_evento_id.exists' => 'A categoria selecionada é inválida.',

            'titulo.required' => 'O título é obrigatório.',
            'titulo.max' => 'O título deve possuir no máximo 255 caracteres.',

            'descricao.required' => 'A descrição é obrigatória.',

            'local.required' => 'O local é obrigatório.',

            'data_evento.required' => 'A data do evento é obrigatória.',
            'data_evento.after_or_equal' => 'A data do evento não pode ser anterior à data atual.',

            'horario_inicio.required' => 'O horário de início é obrigatório.',

            'horario_fim.required' => 'O horário de término é obrigatório.',
            'horario_fim.after' => 'O horário de término deve ser posterior ao horário de início.',

            'max_participantes.required' => 'O número máximo de participantes é obrigatório.',
            'max_participantes.integer' => 'O número máximo de participantes deve ser um número inteiro.',
            'max_participantes.min' => 'O evento deve permitir pelo menos 1 participante.',

            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status selecionado é inválido.',
        ];
    }
}