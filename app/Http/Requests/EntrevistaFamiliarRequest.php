<?php

namespace App\Http\Requests;

use App\Enums\TipoFormularioEnum;
use App\Models\EntrevistaFamiliar;
use App\Models\Estudante;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EntrevistaFamiliarRequest extends FormRequest
{
    use ComCamposAdicionais;

    public function authorize(): bool
    {
        $entrevista = $this->route('entrevistaFamiliar');
        if ($entrevista) {
            return $this->user()->can('update', $entrevista);
        }

        return $this->user()->can('create', EntrevistaFamiliar::class);
    }

    protected function prepareForValidation(): void
    {
        $estudante = $this->route('estudante');

        $this->merge([
            'user_id' => Auth::id(),
            'estudante_id' => $estudante instanceof Estudante ? $estudante->id : $estudante,
        ]);
        $this->definirTemplate(TipoFormularioEnum::ENTREVISTA_FAMILIAR, $this->route('entrevistaFamiliar'));
        $this->prepararCampos();
    }

    public function rules(): array
    {
        $registro = $this->route('entrevistaFamiliar');

        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'estudante_id' => ['required', 'integer', 'exists:estudantes,id'],
            'data' => ['required', 'date'],
            'responsavel_preenchimento' => ['required', 'string', 'max:200'],
            'template_formulario_id' => ['nullable', 'integer', 'exists:templates_formulario,id'],

            ...$this->regrasCamposAdicionais($this->chavesPermitidasPara(
                TipoFormularioEnum::ENTREVISTA_FAMILIAR,
                $registro instanceof EntrevistaFamiliar ? $registro : null,
                $this->input('template_formulario_id'),
            )),
        ];
    }

    public function attributes(): array
    {
        return $this->rotulosCamposAdicionais();
    }
}
