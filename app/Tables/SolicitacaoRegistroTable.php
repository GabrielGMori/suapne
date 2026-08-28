<?php

namespace App\Tables;

use App\Enums\RoleEnum;
use App\Models\SolicitacaoRegistro;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;

class SolicitacaoRegistroTable extends ListViewConfig
{
    public function query(): Builder
    {
        return SolicitacaoRegistro::query();
    }

    public function title(): ?string { return 'Solicitações pendentes'; }
    public function emptyMessage(): string { return 'Nenhuma solicitação de registro foi encontrada.'; }
    public function icon(): string|\Closure { return static fn($item) => match ($item->role) {
        RoleEnum::TECNICO => 'server_person',
        default => 'person'
    }; }

    public function columns(): array
    {
        return [
            ListViewColumn::make('nome')->label('Nome'),
            ListViewColumn::make('email')->label('E-mail')->size('large'),
            ListViewColumn::make('role')->label('Função')->format(fn($value) => $value->label())->size('small'),
            ListViewColumn::make('disciplinas')->label('Disciplinas')->size('large')
                ->format(fn($value) => $value->count() > 0
                ? view('components.item-expansivel', [
                    'items' => $value->map(fn($disciplina) => "$disciplina->nome - {$disciplina->curso->nome}")->toArray(),
                    'label' => 'Disciplinas'
                ])->render()
                : '---'),
            ListViewColumn::make('created_at')->label('Data')->format(fn($value) => $value->format('d/m/Y \à\s H:i'))->size('tiny'),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nome')->label('Nome'),
            ListViewFilter::make('email')->label('E-mail'),
            ListViewFilter::make('role')->label('Função')->type('select')
            ->options([
                RoleEnum::PROFESSOR_REGULAR->value => RoleEnum::PROFESSOR_REGULAR->label(),
                RoleEnum::TECNICO->value => RoleEnum::TECNICO->label()
            ])->equals(),
            ListViewFilter::make('created_at_inicial')->label('Data inicial')->type('date')->size('small')->startingDateInterval('created_at'),
            ListViewFilter::make('created_at_final')->label('Data final')->type('date')->size('small')->endingDateInterval('created_at'),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make('#')->icon('person_remove')->color('red'),
            ListViewAction::make('#')->icon('person_add')->color('primary')
        ];
    }
}
