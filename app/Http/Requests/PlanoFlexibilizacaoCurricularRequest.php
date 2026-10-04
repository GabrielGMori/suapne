<?php

namespace App\Http\Requests;

use App\Enums\TipoFormularioEnum;
use App\Models\PlanoFlexibilizacaoCurricular;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PlanoFlexibilizacaoCurricularRequest extends FormRequest
{
    use ComCamposAdicionais;

    public function authorize(): bool
    {
        return $this->user()->can('create',PlanoFlexibilizacaoCurricular::class);
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => Auth::id(),
        ]);
        $this->prepararCampos();
    }

    public function rules(): array
    {
        $registro = $this->route('planoFlexibilizacao');

        return [
            'user_id' => ['required','integer','exists:users,id'],
            'estudante_id' => ['required','integer','exists:estudantes,id'],
            'periodo_inicio' => ['required','date'],
            'periodo_fim' => ['required','date','after:periodo_inicio'],
            'template_formulario_id' => ['nullable', 'integer', 'exists:templates_formulario,id'],

            ...$this->regrasCamposAdicionais($this->chavesPermitidasPara(
                TipoFormularioEnum::PLANO_FLEXIBILIZACAO,
                $registro instanceof PlanoFlexibilizacaoCurricular ? $registro : null,
                $this->input('template_formulario_id'),
            )),
        ];
    }

    public function attributes(): array
    {
        return $this->rotulosCamposAdicionais();
    }
}
