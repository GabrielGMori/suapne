<?php

namespace App\Http\Requests;

use App\Models\Disciplina;
use App\Models\Curso;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisciplinaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Disciplina::class);
    }

    public function rules(): array
    {
        $disciplina = $this->route('disciplina');
        $maxPeriodo = Curso::whereKey($this->input('curso_id'))->value('quantidade_periodos') ?? PHP_INT_MAX;

        return [
            'nome' => ['required','string', 'max:50'],
            'ementa' => ['required','string'],
            'curso_periodo' => ['required','integer','min:1', 'max:' . $maxPeriodo],
            'curso_id' => ['required', 'integer', 'exists:cursos,id'],
        ];
    }
}
