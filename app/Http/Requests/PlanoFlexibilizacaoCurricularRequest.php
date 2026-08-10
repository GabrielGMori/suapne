<?php

namespace App\Http\Requests;

use App\Models\PlanoFlexibilizacaoCurricular;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PlanoFlexibilizacaoCurricularRequest extends FormRequest
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
        $planosFlexibilizacao = $this->route('planos-flexibilizacao');

        return [
            'periodo_inicio' => ['required','date'],
            'periodo_fim' => ['required','date','after:periodo_inicio'],   
            'campos' => ['required','array'],
            'campos.adaptacaoPedagogica' => ['required','string'],
            'campos.atendimentoMultiprofissional' => ['required','string'],
            'campos.diferenciacao' => ['required','string'],
            'campos.atendimentoIndividualizado' => ['required','string'],
            'campos.alteracaoPrazoCurso' => ['required','string'], 
            'campos.reorganizacaoComponenteCurricular' => ['required','string'],
            'campos.criteriosDiferenciadosAvaliacao' => ['required','string'], 
            'campos.componentesCurriculares' => ['required','integer'],
            'campos.informacoesAdicionais' => ['required','string'],     
        ];
    }
}
