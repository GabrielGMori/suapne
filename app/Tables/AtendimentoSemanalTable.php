<?php

namespace App\Tables;


use App\Models\Estudante;

use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Models\AtendimentoSemanal;

class AtendimentoSemanalTable extends ListViewConfig
{
    public function query(): Builder
    {
        return AtendimentoSemanal::query()->orderBy('data', 'desc');
    }
    public function title(): ?string { return 'Atendimentos Semanais'; }
    public function createUrl(): ?string { return route('atendimentos.create'); }
    public function createLabel(): ?string { return 'Criar Novo'; }
    public function emptyMessage(): string { return 'Nenhum atendimento semanal foi encontrado'; }
    public function icon(): string|Closure { return "article_person"; }

    public function columns(): array
    {
        $cache = [];

        return [
            ListViewColumn::make('estudante.nome')->label('Nome do estudante'),
            ListViewColumn::make('user.nome')->label('Feito por'),
            ListViewColumn::make('local')->label('Local')->size("medium"),
            ListViewColumn::make('data')->label('Data')->format(fn($value) => $value->format('d/m/Y H:i')),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('estudante')->foreignKey('nome')->label('Nome do estudante')->size('large'),
            ListViewFilter::make('user')->foreignKey('nome')->label('Feito por')->size('large'),
            ListViewFilter::make('local')->label('Local do atendimento'),
            ListViewFilter::make('created_at_inicial')->label('Data inicial')->type('date')->size('small')->startingDateInterval('data'),
            ListViewFilter::make('created_at_final')->label('Data final')->type('date')->size('small')->endingDateInterval('data'),
        ];
    }

    public function actions(): array
    {
        return [
        ListViewAction::make(static fn(AtendimentoSemanal $item) => route('atendimentos.show', ['atendimento' => $item->id])),
        ];
    }

}
