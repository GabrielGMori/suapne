<?php

namespace App\Http\Requests;

use App\Enums\StatusPlanoTrabalhoEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class PlanoTrabalhoEstudanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
        ]);
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(StatusPlanoTrabalhoEnum::class)],
            'periodo_inicio' => ['sometimes', 'required', 'date'],
            'periodo_fim' => ['sometimes', 'required', 'date', 'after_or_equal:periodo_inicio'],
            'estudante_id' => ['sometimes', 'required', 'exists:estudantes,id'],
            'user_id' => ['sometimes', 'required', 'exists:users,id'],

            'disciplinas' => ['sometimes', 'required', 'array'],
            'disciplinas.*' => ['sometimes', 'required', 'exists:disciplinas,id'],

            'professores' => ['sometimes', 'required', 'array'],
            'professores.*' => ['sometimes', 'required', 'exists:users,id'],

            'campos' => ['sometimes', 'required', 'array'],
            'campos.cargaHoraria' => ['nullable', 'string'],
            'campos.diaHora' => ['sometimes', 'required', 'date'],
            'campos.local' => ['sometimes', 'required', 'string'],
            'campos.particularidadesEstudante' => ['sometimes', 'required', 'string'],
            'campos.objetivosEspecificos' => ['sometimes', 'required', 'string'],
            'campos.instrumentosAvaliativos' => ['sometimes', 'required', 'string'],
            'campos.outrasConsideracoes' => ['nullable', 'string'],
        ];
    }
}
