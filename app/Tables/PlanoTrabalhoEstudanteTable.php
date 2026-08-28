<?php

namespace App\Tables;

use App\Enums\StatusPlanoTrabalhoEnum;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Estudante;
use App\Models\PlanoTrabalhoEstudante;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\SoftDeletes;
class PlanoTrabalhoEstudanteTable extends ListViewConfig
{
    public function query(): Builder
    {
        return PlanoTrabalhoEstudante::query()->orderBy('status')->orderBy('periodo_inicio', 'desc');
    }
    public function title(): ?string { return 'Planos de Trabalho do Estudante'; }
    public function createUrl(): ?string { return route('planos-trabalho.create'); }
    public function createLabel(): ?string { return 'Criar Novo'; }
    public function emptyMessage(): string { return 'Nenhum plano de trabalho do estudante foi encontrado'; }
    public function icon(): string|\Closure { return "assignment"; }

    public function columns(): array
    {
        $cache = [];

        return [
            ListViewColumn::make('estudante.nome')->label('Nome do estudante'),
            ListViewColumn::make('disciplina.nome')->label('Componente curricular'),
            ListViewColumn::make('disciplina.curso')->label('Curso'),
            ListViewColumn::make('ano')->label('Ano')->size('small'),
            ListViewColumn::make('status')->label('Status')->size('small')->format(
                function ($value) use (&$statusCache) {
                    $label = gettype($value) === 'string' ? $value : $value->label();
                    return $statusCache[$label] ??= view('components.status', [
                        'label' => $value->badgeLabel(),
                        'color' => $value->color(),
                    ])->render();
                }
            ),
        ];


    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('estudante')->foreignKey('nome')->label('Nome do estudante')->size('large'),
            ListViewFilter::make('disciplina')->foreignKey('curso_id')->label('Curso')->size('large')->type('select')->equals()
                ->options(Curso::pluck('nome', 'id')->toArray()),
            ListViewFilter::make('ano')->label('Ano')->size('tiny')
                ->applyUsing(fn(Builder $query, string $value) => $query->whereYear('periodo_inicio', $value)),
            ListViewFilter::make('status')->label('Status')->size('small')->type('select')->options(StatusPlanoTrabalhoEnum::options())->equals(),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make(static fn(PlanoTrabalhoEstudante $item) => route('planos-trabalho.show', ['plano_trabalho' => $item])),
        ];
    }
}
