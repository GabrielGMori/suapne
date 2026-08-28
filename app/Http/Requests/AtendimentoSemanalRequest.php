<?php

namespace App\Http\Requests;

use App\Models\AtendimentoSemanal;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AtendimentoSemanalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create',AtendimentoSemanal::class);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
        ]);
    }

    public function rules(): array
    {
        $atendimento = $this->route('atendimentos');

        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'estudante_id' => ['required', 'integer', 'exists:estudantes,id'],
            'local' => ['required', 'string'],
            'data' => ['required', 'date'],
            'campos' => ['required', 'array'],

            'campos.perfilDoEstudante' => ['required','string'],
            'campos.registroDoAtendimento' => ['required','string'],
            'campos.encaminhamentos' => ['required','string'],
            'campos.observacoesAdicionais' => ['nullable','string']
        ];
    }
}
