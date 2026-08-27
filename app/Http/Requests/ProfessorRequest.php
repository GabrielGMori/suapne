<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfessorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'disciplinas' => ['nullable', 'array'],
            'disciplinas.*' => ['exists:disciplinas,id'],
            'avatar' => ['nullable', 'string', 'max:255'],
        ];
    }
}
