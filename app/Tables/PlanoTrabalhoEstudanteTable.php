<?php

namespace App\Tables;

use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Estudante;
use App\Models\PlanoTrabalhoEstudante;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;

class PlanoTrabalhoEstudanteTable extends ListViewConfig

{


public function getCursoAttribute()
    {
        return $this->estudante ? $this->estudante->curso : 'Sem Curso';
    }
    public function query(): Builder
    {
        return PlanoTrabalhoEstudante::query();
    }
    public function title(): ?string { return 'Planos de Trabalho do Estudante'; }
    public function createUrl(): ?string { return route('planos-trabalho.form'); }
    public function createLabel(): ?string { return 'Criar Novo'; }
    public function emptyMessage(): string { return 'Nenhum plano de trabalho  foi encontrado'; }
    public function icon(): string|\Closure { return "assignment"; }
    
    public function columns(): array
    {
        $cache = [];

        return [
            ListViewColumn::make('estudante.nome')->label('Nome do estudante')->size("large"),
            ListViewColumn::make('disciplina,nome')->label('Componente curricular'),
            ListViewColumn::make('curso')->label('Curso')->size('large'),
            ListViewColumn::make('ano')->label('Ano')->size('small'),
        ];   
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('estudante.nome')->label('Nome do estudante')->size('large'),
            ListViewFilter::make('disciplina')->label('Componente curricular')->type('select')
            ->options(Disciplina::all()->pluck('nome', 'id')->toArray()),
            ListViewFilter::make('curso')->label('Curso')->size('large')->type('select')->options(Curso::all()->pluck('nome', 'id')->toArray()),
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
