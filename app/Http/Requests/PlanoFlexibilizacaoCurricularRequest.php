<?php

namespace App\Http\Requests;

use App\Models\PlanoFlexibilizacaoCurricular;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PlanoFlexibilizacaoCurricularRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create',PlanoFlexibilizacaoCurricular::class);
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
            'user_id' => ['required','integer','exists:users,id'],
            'estudante_id' => ['required','integer','exists:estudantes,id'],
            'periodo_inicio' => ['required','date'],
            'periodo_fim' => ['required','date','after:periodo_inicio'],
            'campos' => ['required','array'],

            'campos.acoesPedagogicas' => ['required','string'],
            'campos.atendimentoMultiprofissional' => ['required','string'],
            'campos.diferenciacaoCurricular' => ['required','string'],
            'campos.atendimentoIndividualizado' => ['required','string'],
            'campos.alteracaoPrazo' => ['required','string'],
            'campos.reorganizacaoCurricular' => ['required','string'],
            'campos.criteriosDiferenciados' => ['required','string'],
            'campos.componentesCurriculares' => ['required','array'],
            'campos.informacoesAdicionais' => ['nullable','string'],
        ];
    }
}
