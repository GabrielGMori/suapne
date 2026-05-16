<?php

namespace App\Tables;

use App\Models\Estudante;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;

class EstudanteTable extends ListViewConfig
{
    public function query(): Builder
    {
        return Estudante::query();
    }
    public function title(): ?string { return 'Estudantes registrados'; }
    public function createUrl(): ?string { return route('estudantes.form'); }
    public function createLabel(): ?string { return 'Registrar Novo'; }
    public function emptyMessage(): string { return 'Nenhum estudante foi encontrado'; }
    public function icon(): string|\Closure { return asset('storage/img/placeholder-user.png'); }
    public function imageIcon(): bool { return true; }
    
    public function columns(): array
    {
        $cache = [];

        return [
            ListViewColumn::make('nome')->label('Nome do estudante')->size('large'),
            ListViewColumn::make('curso')->label('Curso do estudante')->size('large'),
            ListViewColumn::make('periodo')->label('Período')->size('small')->format(fn($value) => $value.'°'),
            ListViewColumn::make('situacao')->label('Situação')->format(function($value) use (&$cache) {
                if (isset($cache[$value])) return $cache[$value];
                return $cache[$value] = view('components.status', ['color' => 'dark', 'label' => $value])->render();
            }),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nome')->label('Nome do estudante')->size('large'),
            ListViewFilter::make('curso')->label('Curso do estudante')->size('large'),
            ListViewFilter::make('periodo')->label('Período')->size('tiny'),
            ListViewFilter::make('situacao')->label('Situação')->type('multiselect')->options(['Matriculado', 'Formado', 'Evadido']),
            ListViewFilter::make('matricula')->label('Matrícula')->hidden(),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make('#'),
        ];
    }

}
