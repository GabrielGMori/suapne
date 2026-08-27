<?php

namespace App\Http\Requests;

use App\Models\Disciplina;
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

        return [
            'nome' => ['required','string', 'max:50'],
            'ementa' => ['required','string'],
            'curso_id' => ['required', 'integer', 'exists:cursos,id'],
        ];
    }
}
