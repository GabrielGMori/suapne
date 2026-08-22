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

    public function messages(): array
    {
        return [
            'periodo_inicio.required' => 'O período de início é obrigatório.',
            'periodo_inicio.date' => 'O período de início deve ser uma data válida.',
            'periodo_fim.required' => 'O período de fim é obrigatório.',
            'periodo_fim.date' => 'O período de fim deve ser uma data válida.',
            'periodo_fim.after_or_equal' => 'O período de fim deve ser igual ou posterior ao início.',
            'estudante_id.required' => 'O estudante é obrigatório.',
            'estudante_id.exists' => 'O estudante selecionado não existe.',
            'disciplina_id.required' => 'A disciplina é obrigatória.',
            'disciplina_id.exists' => 'A disciplina selecionada não existe.',
            'user_professor_id.required' => 'O professor é obrigatório.',
            'user_professor_id.exists' => 'O professor selecionado não existe.',
            'campos.required' => 'Os campos do plano de trabalho são obrigatórios.',
            'campos.array' => 'Os campos do plano de trabalho devem possuir um formato válido.',
        ];
    }
}