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
            'nome' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:200'],
            'disciplinas' => ['nullable', 'array'],
            'disciplinas.*' => ['exists:disciplinas,id'],
            'avatar' => ['nullable', 'string', 'max:255'],
        ];
    }
}
