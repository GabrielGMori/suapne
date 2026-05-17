<?php

namespace App\Tables;

use App\Models\Curso;
use App\Models\Estudante;
use App\Models\PlanoFlexibilizacao;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;

class CursoTable extends ListViewConfig
{
    public function query(): Builder
    {
        return Curso::query();
    }
    public function title(): ?string { return 'Cursos'; }
    public function createUrl(): ?string { return route('cursos.form'); }
    public function createLabel(): ?string { return 'Criar Novo'; }
    public function emptyMessage(): string { return 'Nenhum curso foi encontrado'; }
    public function icon(): string|\Closure { return "backpack"; }
    
    public function columns(): array
    {
        $cache = [];

        return [
            ListViewColumn::make('nomeCurso')->label('Nome do curso')->size("full"),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make('#'),
        ];
    }

}
