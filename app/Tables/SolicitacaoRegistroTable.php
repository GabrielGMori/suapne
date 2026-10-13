<?php

namespace App\Tables;

use App\Enums\RoleEnum;
use App\Enums\StatusSolicitacaoRegistroEnum;
use App\Models\Disciplina;
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
        return SolicitacaoRegistro::query()->oldest();
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
            ListViewColumn::make('email')->label('E-mail'),
            ListViewColumn::make('role')->label('Função')->format(fn($value) => $value->label()),
            ListViewColumn::make('disciplinas')->label('Disciplinas')
            ->format(fn($value) => $value->count() > 0 ? view('components.modal.simple-text', [
                'label' => 'Ver disciplinas',
                'title' => 'Disciplinas',
                'value' => $value->map(fn($disciplina) => "• {$disciplina->nome} - {$disciplina->curso->nome}")->toArray()
            ])->render() : '---'),
            ListViewColumn::make('created_at')->label('Data')->format(fn($value) => $value->format('d/m/Y \à\s H:i'))->size('tiny'),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nome')->label('Nome'),
            ListViewFilter::make('email')->label('E-mail'),
            ListViewFilter::make('role')->label('Função')->type('select')
                ->options(RoleEnum::options())->equals(),
            ListViewFilter::make('status')->label('Status')->type('select')
                ->options(StatusSolicitacaoRegistroEnum::options())->equals(),
            ListViewFilter::make('disciplinas')->foreignKey('disciplinas.id')->label('Disciplinas')->size('xlarge')->type('multiselect')->equals()
                ->options(Disciplina::with('curso')->get()->mapWithKeys(fn(Disciplina $d) => [$d->id => "{$d->nome} - {$d->curso?->nome}"])->toArray())->hidden(),
            ListViewFilter::make('created_at_inicial')->label('Data inicial')->type('date')->size('small')->startingDateInterval('created_at'),
            ListViewFilter::make('created_at_final')->label('Data final')->type('date')->size('small')->endingDateInterval('created_at'),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make(fn($item) => route('cadastro.decline', ['solicitacao' => $item]))->icon('person_remove')->color('red')
                ->confirm()->confirmMessage(fn($item) => "Tem certeza de que deseja recusar esta solicitação de {$item->nome}?")
                ->textarea(name: 'observacao', label: 'Observação (opcional)')
                ->color('red')
                ->filledConfirm()->method('POST'),
            ListViewAction::make(fn($item) => route('cadastro.accept', ['solicitacao' => $item]))->icon('person_add')->color('primary')
                ->confirm()->confirmMessage(fn($item) => "Tem certeza de que deseja aceitar esta solicitação de {$item->nome}?")
                ->filledConfirm()->method('POST'),
        ];
    }
}
