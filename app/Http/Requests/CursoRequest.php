<?php

namespace App\Http\Requests;

use App\Models\Curso;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Curso::class);
    }

    public function rules(): array
    {
        $curso = $this->route('curso');

        return [
            'nome' => ['required','string', 'max:50'],
            'quantidade_periodos' => ['required','integer', 'min:1'],
        ];
    }
}
