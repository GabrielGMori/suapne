<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CnapneRequest extends FormRequest
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
            'role' => ['required', Rule::enum(RoleEnum::class)],
            'avatar' => ['nullable', 'string', 'max:255'],
        ];
    }
}
