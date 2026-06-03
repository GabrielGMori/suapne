<?php

namespace App\Tables;

use App\Enums\TipoRegistroAcaoEnum;
use App\Models\RegistroAcao;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewConfig;
use App\View\Components\ListViewFilter;
use Illuminate\Database\Eloquent\Builder;

class RegistroAcaoTable extends ListViewConfig
{
    public function query(): Builder
    {
        return RegistroAcao::query()->with(['user', 'estudante']);
    }

    public function title(): ?string { return 'Ações registradas no sistema'; }

    public function emptyMessage(): string { return 'Nenhuma ação foi encontrada'; }

    public function icon(): \Closure
    {
        return fn(RegistroAcao $item) => $item->user?->avatar
            ? asset($item->user->avatar)
            : asset('storage/img/placeholder-user.png');
    }

    public function imageIcon(): bool { return true; }

    public function columns(): array
    {
        $statusCache = [];

        return [
            ListViewColumn::make('user.nome')->label('Nome do autor'),
            ListViewColumn::make('estudante.nome')->label('O que foi alterado'),
            ListViewColumn::make('created_at')->label('Data')->format(fn($value) => $value->format('d/m/Y H:i')),
            ListViewColumn::make('acao')->label('Ação')->format(
                function ($value, $item) use (&$statusCache) {
                    $label = gettype($value) === 'string' ? $value : $value->label();
                    return $statusCache[$label] ??= view('components.status', [
                        'label' => $label,
                        'color' => match($item->tipo) {
                            TipoRegistroAcaoEnum::CRIACAO => 'success',
                            TipoRegistroAcaoEnum::EDICAO => 'warning',
                            TipoRegistroAcaoEnum::EXCLUSAO => 'danger',
                        },
                    ])->render();
                }
            ),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('user')->foreignKey('nome')->label('Nome do autor'),
            ListViewFilter::make('estudante')->foreignKey('nome')->label('Nome do estudante'),
            ListViewFilter::make('created_at_start')->label('Data inicial')->size('small')->type('date')->startingDateInterval('created_at'),
            ListViewFilter::make('created_at_end')->label('Data final')->size('small')->type('date')->endingDateInterval('created_at'),
            ListViewFilter::make('tipo')->label('Tipo de ação')->size('small')->type('multiselect')->options(TipoRegistroAcaoEnum::options()),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make('#')
        ];
    }
}
