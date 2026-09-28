<?php

namespace App\Models\Concerns;

use App\Support\FormularioPadrao;

trait TemCamposAdicionais
{
    public function camposAdicionais(): array
    {
        return $this->campos_extras ?? FormularioPadrao::camposAdicionais(static::TIPO_FORMULARIO);
    }

    public function camposAdicionaisFiltrados(string $secao = '', string $etapa = '', int $ordemMin = 0, ?int $ordemMax = null): array
    {
        return FormularioPadrao::filtrar($this->camposAdicionais(), $secao, $etapa, $ordemMin, $ordemMax);
    }

    public function camposAdicionaisAgrupados(string $secao = '', string $etapa = '', int $ordemMin = 0, ?int $ordemMax = null): array
    {
        return FormularioPadrao::agrupar($this->camposAdicionaisFiltrados($secao, $etapa, $ordemMin, $ordemMax));
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
