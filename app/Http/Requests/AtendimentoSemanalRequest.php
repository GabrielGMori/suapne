<?php

namespace App\Http\Requests;

use App\Enums\TipoFormularioEnum;
use App\Models\AtendimentoSemanal;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AtendimentoSemanalRequest extends FormRequest
{
    use ComCamposAdicionais;

    public function authorize(): bool
    {
        return $this->user()->can('create',AtendimentoSemanal::class);
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
        $registro = $this->route('atendimento');

        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'estudante_id' => ['required', 'integer', 'exists:estudantes,id'],
            'local' => ['required', 'string', 'max:100'],
            'data' => ['required', 'date'],
            'template_formulario_id' => ['nullable', 'integer', 'exists:templates_formulario,id'],

            ...$this->regrasCamposAdicionais($this->chavesPermitidasPara(
                TipoFormularioEnum::ATENDIMENTO_SEMANAL,
                $registro instanceof AtendimentoSemanal ? $registro : null,
                $this->input('template_formulario_id'),
            )),
        ];
    }

    public function attributes(): array
    {
        return $this->rotulosCamposAdicionais();
    }
}
