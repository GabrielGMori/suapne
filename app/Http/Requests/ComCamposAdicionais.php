<?php

namespace App\Http\Requests;

use App\Enums\TipoFormularioEnum;
use App\Models\ModeloFormulario;
use App\Support\FormularioPadrao;
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
            'campos_extras.*.rotulo' => ['required', 'string', 'max:150'],
            'campos_extras.*.tipo' => ['required', 'string', 'max:30'],
            'campos_extras.*.obrigatorio' => ['nullable', 'boolean'],
            'campos_extras.*.padrao' => ['nullable', 'boolean'],
            'campos_extras.*.snapshot' => ['nullable', 'boolean'],
            'campos_extras.*.ordem' => ['nullable', 'integer'],
            'campos_extras.*.secao' => ['nullable', 'string', 'max:50'],
            'campos_extras.*.etapa' => ['nullable', 'string', 'max:50'],
            'campos_extras.*.grupo' => ['nullable', 'string', 'max:50'],
            'campos_extras.*.grupoTitulo' => ['nullable', 'string', 'max:300'],
            'campos_extras.*.descricao' => ['nullable', 'string', 'max:300'],
            'campos_extras.*.rotuloFormulario' => ['nullable', 'string', 'max:150'],
            'campos_extras.*.regra' => ['nullable', 'string', 'max:30'],
            'campos_extras.*.opcoes' => ['nullable', 'array'],
        ];

        foreach ((array) $this->input('campos_extras', []) as $campo) {
            if (!is_array($campo) || !in_array($campo['chave'] ?? null, $chavesPermitidas, true)) {
                continue;
            }

            if (filter_var($campo['snapshot'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
                continue;
            }

            $regra = FormularioPadrao::regra($campo);

            $regras["campos.{$campo['chave']}"] = filter_var($campo['obrigatorio'] ?? false, FILTER_VALIDATE_BOOLEAN)
                ? ['required', $regra]
                : ['nullable', $regra];
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

    protected function chavesPermitidasPara(TipoFormularioEnum $tipo, ?Model $registro, mixed $estudanteId): array
    {
        $modelo = ModeloFormulario::para($tipo, filled($estudanteId) ? (int) $estudanteId : null);
        $doRegistro = $registro ? array_column($registro->camposAdicionais(), 'chave') : [];

        return array_values(array_unique([...$modelo->chaves(), ...$doRegistro]));
    }

    protected function prepararCampos(): void
    {
        $this->merge(['campos' => (array) $this->input('campos', [])]);
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
                'padrao' => filter_var($campo['padrao'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'ordem' => (int) ($campo['ordem'] ?? FormularioPadrao::ORDEM_PERSONALIZADO),
            ];

            foreach (['secao', 'etapa', 'grupo', 'grupoTitulo', 'descricao', 'rotuloFormulario', 'regra', 'opcoes'] as $opcional) {
                if (filled($campo[$opcional] ?? null)) {
                    $item[$opcional] = $campo[$opcional];
                }
            }

            $lista[] = $item;
        }

        usort($lista, fn($a, $b) => $a['ordem'] <=> $b['ordem']);

        return $lista;
    }
}
