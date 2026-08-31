<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use App\Enums\StatusSolicitacaoRegistroEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SolicitacaoRegistroRequest extends FormRequest
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
            'nome' => ['required', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:200', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'max:200', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:8', 'max:200'],
            'role' => ['required', Rule::enum(RoleEnum::class)],
            'status' => [Rule::enum(StatusSolicitacaoRegistroEnum::class)],
            'campos' => ['required_if:role,' . RoleEnum::PROFESSOR_REGULAR->value, 'array'],

            'campos.disciplinas' => ['required_if:role,' . RoleEnum::PROFESSOR_REGULAR->value, 'array'],
            'campos.disciplinas.*' => ['exists:disciplinas,id'],
        ];
    }
}
