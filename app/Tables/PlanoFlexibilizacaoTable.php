<?php

namespace App\Tables;

use App\Models\Estudante;
use App\Models\PlanoFlexibilizacao;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;

class PlanoFlexibilizacaoTable extends ListViewConfig
{
    public function query(): Builder
    {
        return PlanoFlexibilizacao::query();
    }
    public function title(): ?string { return 'Planos de Flexibilização Curricular'; }
    public function createUrl(): ?string { return route('planos-flexibilizacao.form'); }
    public function createLabel(): ?string { return 'Criar Novo'; }
    public function emptyMessage(): string { return 'Nenhum plano de flexibilização foi encontrado'; }
    public function icon(): string|\Closure { return "assignment"; }
    
    public function columns(): array
    {
        $cache = [];

        return [
            ListViewColumn::make('nomeEstudante')->label('Nome do estudante')->size("large"),
            ListViewColumn::make('disciplina')->label('Componente curricular'),
            ListViewColumn::make('curso')->label('Curso')->size('large'),
            ListViewColumn::make('ano')->label('Ano')->size('small'),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nomeEstudante')->label('Nome do estudante')->size('large'),
            ListViewFilter::make('disciplina')->label('Componente curricular')->type('select')
            ->options(['Português', 'Matemática', "Artes", "Física", "História"]),
            ListViewFilter::make('curso')->label('Curso')->size('large'),
            ListViewFilter::make('ano')->label('Ano')->size('tiny'),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make('#'),
        ];
    }

}
