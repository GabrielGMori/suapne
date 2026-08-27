<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class   PlanoTrabalhoEstudanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'periodo_inicio' => [
                'required',
                'date',
            ],

            'periodo_fim' => [
                'required',
                'date',
                'after_or_equal:periodo_inicio',
            ],

            'estudante_id' => [
                'required',
                'exists:estudantes,id',
            ],

            'disciplina_id' => [
                'required',
                'exists:disciplinas,id',
            ],

            'user_professor_id' => [
                'required',
                'exists:users,id',
            ],

            'campos' => [
                'required',
                'array',
            ],
        ];
    }
}
