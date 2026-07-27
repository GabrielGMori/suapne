<?php

namespace App\Tables;

use App\Enums\SituacaoEstudanteEnum;
use App\Models\Curso;
use App\Models\Estudante;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewConfig;
use App\View\Components\ListViewFilter;
use Illuminate\Database\Eloquent\Builder;

class EstudanteTable extends ListViewConfig
{
    public function query(): Builder
    {
        return Estudante::query()->orderBy('created_at', 'DESC');
    }

    public function title(): ?string
    {
        return 'Estudantes registrados';
    }

    public function createUrl(): ?string
    {
        return route('estudantes.create');
    }

    public function createLabel(): ?string
    {
        return 'Registrar Novo';
    }

    public function emptyMessage(): string
    {
        return 'Nenhum estudante foi encontrado';
    }

    public function icon(): \Closure
    {
        return fn(Estudante $item) => $item->avatar
            ? asset($item->avatar)
            : asset('storage/img/placeholder-user.png');
    }

    public function imageIcon(): bool
    {
        return true;
    }

    public function columns(): array
    {
        $statusCache = [];

        return [
            ListViewColumn::make('nome')->label('Nome do estudante')->size('large'),
            ListViewColumn::make('curso')->label('Curso do estudante')->size('large'),
            ListViewColumn::make('periodo')->label('Período')->size('small')->format(
                fn($value) => $value . '°'
            ),
            ListViewColumn::make('situacao')->label('Situação')->format(
                function ($value) use (&$statusCache) {
                    $label = $value instanceof SituacaoEstudanteEnum ? $value->label() : $value;
                    return $statusCache[$label] ??= view('components.status', [
                        'color' => 'dark',
                        'label' => $label,
                    ])->render();
                }
            ),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nome')->label('Nome do estudante')->size('large'),
            ListViewFilter::make('curso_id')->label('Curso do estudante')->size('large')->type('multiselect')->options(Curso::all()->pluck('nome', 'id')->toArray()),
            ListViewFilter::make('periodo')->label('Período')->size('tiny'),
            ListViewFilter::make('situacao')->label('Situação')->type('multiselect')->options(SituacaoEstudanteEnum::options()),
            ListViewFilter::make('matricula')->label('Matrícula')->hidden(),
            ListViewFilter::make('excluido')->label('Excluído')->size('small')->type('select')->options([
                0 => 'Não',
                1 => 'Sim'
            ])->applyUsing(fn(Builder $query, array $value) => $value[0] == 1 ? $query->onlyTrashed() : $query)->hidden(),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make(static fn(Estudante $item) => $item->trashed()
                ? $item->restore()
                : route('estudantes.show', ['estudante' => $item])),
        ];
    }
}
