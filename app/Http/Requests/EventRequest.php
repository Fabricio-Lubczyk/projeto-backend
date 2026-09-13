<?php

namespace App\Http\Requests;

use App\Models\Venue;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'venue_id' => ['required', 'integer', 'exists:venues,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after:starts_at'],
            'capacity' => ['required', 'integer', 'min:1'],
            'status' => ['required', Rule::in(['rascunho', 'publicado', 'cancelado'])],
        ];
    }

    /**
     * Get the validation callbacks for the request.
     *
     * @return array<int, \Closure(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $venue = Venue::query()->find($this->integer('venue_id'));

                if ($venue !== null && $this->integer('capacity') > $venue->capacity) {
                    $validator->errors()->add('capacity', 'A capacidade do evento não pode ultrapassar a capacidade do local.');
                }
            },
        ];
    }
}
