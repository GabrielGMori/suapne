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
use Illuminate\Support\Facades\Auth;

class DisciplinaTable extends ListViewConfig
{
    public function query(): Builder
    {
        return Disciplina::query()->latest();
    }

    public function title(): ?string { return 'Disciplinas registradas'; }
    public function canCreate(): bool { return Auth::user()->can('create', Disciplina::class); }
    public function createUrl(): ?string { return route('disciplinas.create'); }
    public function createLabel(): ?string { return 'Cadastrar Nova'; }
    public function emptyMessage(): string { return 'Nenhuma disciplina foi encontrada'; }
    public function icon(): string|\Closure { return "book"; }

    public function columns(): array
    {
        return [
            ListViewColumn::make('nome')->label('Componente curricular')->size("large")->link(fn($item) => route('disciplinas.edit', $item)),
            ListViewColumn::make('curso.nome')->label('Curso')->size("large")->link(fn($item) => route('cursos.edit', $item->curso)),
            ListViewColumn::make('curso_periodo')->label('Período')->size("small"),
            ListViewColumn::make('ementa')->label('Ementa')->size("large")
            ->format(fn($value) => view('components.modal.simple-text', [
                'label' => 'Ver ementa',
                'title' => 'Ementa',
                'value' => $value,
            ])->render())
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
            ListViewAction::make(static fn(Disciplina $item) => route('disciplinas.edit', ['disciplina' => $item]))->icon('edit'),
        ];
    }

}
