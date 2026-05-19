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

class DisciplinaTable extends ListViewConfig
{
    public function query(): Builder
    {
        return Disciplina::query();
    }

    public function title(): ?string { return 'Disciplinas registradas'; }
    public function createUrl(): ?string { return route('disciplinas.form'); }
    public function createLabel(): ?string { return 'Cadastrar Novo'; }
    public function emptyMessage(): string { return 'Nenhuma disciplina foi encontrada'; }
    public function icon(): string|\Closure { return "book"; }

    public function columns(): array
    {
        return [
            ListViewColumn::make('nome')->label('Componente curricular')->size("large"),
            ListViewColumn::make('curso.nome')->label('Curso')->size("large"),
            ListViewColumn::make('ementa')->label('Ementa')->size("large")
            ->format(fn($value) => view('components.item-expansivel', ['items' => [$value], 'label' => 'Ementa'])->render())
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nome')->label('Nome do componente curricular')->size('large'),
            ListViewFilter::make('curso')->foreignKey('id')->label('Nome do curso')->size('large')->type('multiselect')
            ->options(Curso::all()->pluck('nome', 'id')->toArray())
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make(fn(Disciplina $item) => route('disciplinas.edit', ['id' => $item->id]))->icon('edit'),
        ];
    }

}
