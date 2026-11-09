<?php

namespace App\Models\Concerns;

use App\Support\CamposTemplate;

trait TemCamposAdicionais
{
    public function camposAdicionais(): array
    {
        return $this->campos_extras ?? CamposTemplate::doTemplate(static::TIPO_FORMULARIO, $this->template_formulario_id);
    }

    public function camposAdicionaisFiltrados(string $secao = '', string $etapa = '', string $ate = '', string $depois = ''): array
    {
        return CamposTemplate::filtrar($this->camposAdicionais(), $secao, $etapa, $ate, $depois);
    }

    public function camposAdicionaisAgrupados(string $secao = '', string $etapa = '', string $ate = '', string $depois = ''): array
    {
        return CamposTemplate::agrupar($this->camposAdicionaisFiltrados($secao, $etapa, $ate, $depois));
    }

    public function numeracaoCampos(): array
    {
        return CamposTemplate::numeracao(static::TIPO_FORMULARIO, $this->camposAdicionais());
    }

    public function temCampo(string $chave): bool
    {
        return in_array($chave, array_column($this->camposAdicionais(), 'chave'), true);
    }

    public function campoAdicional(string $chave): ?array
    {
        foreach ($this->camposAdicionais() as $campo) {
            if ($campo['chave'] === $chave) {
                return $campo;
            }
        }

        return null;
    }

    public function valorCampo(string $chave): mixed
    {
        return $this->campos[$chave] ?? null;
    }

    public static function mesclarCamposExtras(array $antigos, ?array $novos): array
    {
        $porChave = [];

        foreach ([...$antigos, ...($novos ?? [])] as $campo) {
            $porChave[$campo['chave']] = $campo;
        }

        return array_values($porChave);
    }
}
