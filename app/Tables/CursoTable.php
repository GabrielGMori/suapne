<?php

namespace App\Tables;

use App\Models\Curso;
use App\Models\Estudante;
use App\Models\PlanoFlexibilizacaoCurricular;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;

class CursoTable extends ListViewConfig
{
    public function query(): Builder
    {
        return Curso::query()->latest();
    }

    public function title(): ?string { return 'Cursos registrados'; }
    public function createUrl(): ?string { return route('cursos.create'); }
    public function createLabel(): ?string { return 'Cadastrar Novo'; }
    public function emptyMessage(): string { return 'Nenhum curso foi encontrado'; }
    public function icon(): string|\Closure { return "backpack"; }

    public function columns(): array
    {
        return [
            ListViewColumn::make('nome')->label('Nome do curso')->size("full"),
            ListViewColumn::make('quantidade_periodos')->label('Quantidade de períodos')->size("medium"),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nome')->label('Nome do curso')->size('large'),
            ListViewFilter::make('quantidade_periodos')->label('Quantidade de períodos')->size('small'),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make(static fn(Curso $item) => route('cursos.edit', ['curso' => $item->id]))->icon('edit'),
        ];
    }

}
