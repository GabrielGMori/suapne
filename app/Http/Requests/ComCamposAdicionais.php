<?php

namespace App\Http\Requests;

use App\Enums\TipoFormularioEnum;
use App\Support\CamposTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

trait ComCamposAdicionais
{
    protected function regrasCamposAdicionais(array $chavesPermitidas): array
    {
        $regras = [
            'campos' => ['present', 'array'],
            'campos_extras' => ['nullable', 'array'],
            'campos_extras.*.chave' => ['required', 'string', Rule::in($chavesPermitidas)],
            'campos_extras.*.rotulo' => ['required', 'string', 'max:300'],
            'campos_extras.*.tipo' => ['required', 'string', 'max:30'],
            'campos_extras.*.obrigatorio' => ['nullable', 'boolean'],
            'campos_extras.*.fixo' => ['nullable', 'boolean'],
            'campos_extras.*.snapshot' => ['nullable', 'boolean'],
            'campos_extras.*.secao' => ['nullable', 'string', 'max:50'],
            'campos_extras.*.etapa' => ['nullable', 'string', 'max:50'],
            'campos_extras.*.grupo' => ['nullable', 'string', 'max:50'],
            'campos_extras.*.grupoTitulo' => ['nullable', 'string', 'max:300'],
            'campos_extras.*.descricao' => ['nullable', 'string', 'max:300'],
            'campos_extras.*.rotuloFormulario' => ['nullable', 'string', 'max:300'],
            'campos_extras.*.motivoFixo' => ['nullable', 'string', 'max:300'],
            'campos_extras.*.regra' => ['nullable', 'string', 'max:30'],
            'campos_extras.*.opcoes' => ['nullable', 'array'],
            'campos_extras.*.min' => ['nullable', 'integer'],
            'campos_extras.*.max' => ['nullable', 'integer'],
            'campos_extras.*.semNumero' => ['nullable', 'boolean'],
            'campos_extras.*.separador' => ['nullable', 'boolean'],
            'campos_extras.*.tamanho' => ['nullable', 'string', 'max:20'],
        ];

        foreach ((array) $this->input('campos_extras', []) as $campo) {
            if (!is_array($campo) || !in_array($campo['chave'] ?? null, $chavesPermitidas, true)) {
                continue;
            }

            if (filter_var($campo['snapshot'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
                continue;
            }

            $regras["campos.{$campo['chave']}"] = [
                filter_var($campo['obrigatorio'] ?? false, FILTER_VALIDATE_BOOLEAN) ? 'required' : 'nullable',
                CamposTemplate::regra($campo),
                ...(filled($campo['min'] ?? null) ? ["min:{$campo['min']}"] : []),
                ...(filled($campo['max'] ?? null) ? ["max:{$campo['max']}"] : []),
            ];
        }

        return $regras;
    }

    protected function rotulosCamposAdicionais(): array
    {
        $rotulos = [];

        foreach ((array) $this->input('campos_extras', []) as $campo) {
            if (is_array($campo) && !empty($campo['chave'])) {
                $rotulos["campos.{$campo['chave']}"] = $campo['rotuloFormulario'] ?? $campo['rotulo'] ?? $campo['chave'];
            }
        }

        return $rotulos;
    }

    protected function chavesPermitidasPara(TipoFormularioEnum $tipo, ?Model $registro, mixed $templateId): array
    {
        $doTemplate = CamposTemplate::doTemplate($tipo, filled($templateId) ? (int) $templateId : null);
        $doRegistro = $registro ? array_column($registro->camposAdicionais(), 'chave') : [];

        return array_values(array_unique([...array_column($doTemplate, 'chave'), ...$doRegistro]));
    }

    protected function prepararCampos(): void
    {
        $this->merge(['campos' => (array) $this->input('campos', [])]);

        if ($this->has('campos_extras')) {
            $this->merge(['campos_extras' => CamposTemplate::decodificar((array) $this->input('campos_extras'))]);
        }
    }

    public function dadosValidados(): array
    {
        $dados = $this->validated();
        $dados['campos'] = $dados['campos'] ?? [];
        $dados['campos_extras'] = $this->camposExtras();

        return $dados;
    }

    public function camposExtras(): ?array
    {
        if (!$this->has('campos_extras')) {
            return null;
        }

        $lista = [];

        foreach ($this->validated()['campos_extras'] ?? [] as $campo) {
            $item = [
                'chave' => $campo['chave'],
                'rotulo' => $campo['rotulo'],
                'tipo' => $campo['tipo'],
                'obrigatorio' => filter_var($campo['obrigatorio'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'fixo' => filter_var($campo['fixo'] ?? false, FILTER_VALIDATE_BOOLEAN),
            ];

            foreach (['secao', 'etapa', 'grupo', 'grupoTitulo', 'descricao', 'rotuloFormulario', 'motivoFixo', 'regra', 'opcoes', 'min', 'max', 'semNumero', 'separador', 'tamanho'] as $opcional) {
                if (filled($campo[$opcional] ?? null)) {
                    $item[$opcional] = $campo[$opcional];
                }
            }

            $lista[] = $item;
        }

        return $lista;
    }
}
