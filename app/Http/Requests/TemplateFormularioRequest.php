<?php

namespace App\Http\Requests;

use App\Support\CamposTemplate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TemplateFormularioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:150'],

            'campos' => ['required', 'array', 'min:1'],
            'campos.*.chave' => ['required', 'string', 'max:60'],
            'campos.*.rotulo' => ['required', 'string', 'max:300'],
            'campos.*.tipo' => ['required', 'string', 'max:30'],
            'campos.*.obrigatorio' => ['nullable', 'boolean'],
            'campos.*.fixo' => ['nullable', 'boolean'],
            'campos.*.secao' => ['nullable', 'string', 'max:50'],
            'campos.*.etapa' => ['nullable', 'string', 'max:50'],
            'campos.*.grupo' => ['nullable', 'string', 'max:50'],
            'campos.*.grupoTitulo' => ['nullable', 'string', 'max:300'],
            'campos.*.descricao' => ['nullable', 'string', 'max:300'],
            'campos.*.rotuloFormulario' => ['nullable', 'string', 'max:150'],
            'campos.*.motivoFixo' => ['nullable', 'string', 'max:300'],
            'campos.*.regra' => ['nullable', 'string', 'max:30'],
            'campos.*.opcoes' => ['nullable', 'array'],

            'estudantes' => ['nullable', 'array'],
            'estudantes.*' => ['exists:estudantes,id'],
        ];
    }

    public function attributes(): array
    {
        return ['nome' => 'nome do template', 'campos' => 'campos'];
    }

    public function after(): array
    {
        return [
            function ($validator) {
                $tipo = $this->route('tipo') ?? $this->route('templateFormulario')?->tipo;

                if ($tipo === null) {
                    return;
                }

                $enviadas = array_column($this->input('campos', []), 'chave');

                foreach (CamposTemplate::campos($tipo) as $campo) {
                    if (($campo['fixo'] ?? false) && !in_array($campo['chave'], $enviadas, true)) {
                        $validator->errors()->add('campos', "O campo \"{$campo['rotulo']}\" não pode ser removido do template.");
                    }
                }

                if (count($enviadas) !== count(array_unique($enviadas))) {
                    $validator->errors()->add('campos', 'Há campos repetidos no template.');
                }
            },
        ];
    }
}
