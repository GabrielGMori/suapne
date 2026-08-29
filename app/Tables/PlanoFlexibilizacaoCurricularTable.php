<?php

namespace App\Tables;

use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Estudante;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;

class PlanoFlexibilizacaoCurricularTable extends ListViewConfig
{
    public function query(): Builder
    {
        return PlanoFlexibilizacaoCurricular::query()->latest();
    }
    public function title(): ?string { return 'Planos de Flexibilização Curricular'; }
    public function createUrl(): ?string { return route('planos-flexibilizacao.create'); }
    public function createLabel(): ?string { return 'Criar Novo'; }
    public function emptyMessage(): string { return 'Nenhum plano de flexibilização foi encontrado'; }
    public function icon(): string|\Closure { return "tune"; }

    public function columns(): array
    {
        $cache = [];

        return [
            ListViewColumn::make('estudante.nome')->label('Nome do estudante')->size("large")->link(fn($item) => route('estudantes.show', $item)),
            ListViewColumn::make('estudante.curso')->label('Curso')->size('large'),
            ListViewColumn::make('ano')->label('Ano')->size('small'),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('estudante')->foreignKey('nome')->identifier('estudanteNome')->label('Nome do estudante')->size('large'),
            ListViewFilter::make('estudante')->foreignKey('curso_id')->identifier('estudanteCurso')->label('Curso')->size('large')->type('select')
                ->options(Curso::all()->pluck('nome', 'id')->toArray())->equals(),
            ListViewFilter::make('ano')->label('Ano')->size('tiny')
                ->applyUsing(fn(Builder $query, string $value) => $query->whereYear('periodo_inicio', $value)),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make(static fn(PlanoFlexibilizacaoCurricular $item) => route('planos-flexibilizacao.show', ['planoFlexibilizacao' => $item->id])),
        ];
    }

}
