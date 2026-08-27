<?php

namespace App\Tables;

use App\View\Components\ListViewAction;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewConfig;
use App\View\Components\ListViewFilter;
use Illuminate\Database\Eloquent\Builder;
use OwenIt\Auditing\Models\Audit;

class RegistroAcaoTable extends ListViewConfig
{
    public function query(): Builder
    {
        return Audit::query()
            ->with(['user', 'auditable'])
            ->latest();
    }

    public function title(): ?string
    {
        return 'Ações registradas no sistema';
    }

    public function emptyMessage(): string
    {
        return 'Nenhuma ação foi encontrada';
    }

    public function icon(): \Closure
    {
        return fn ($item) => $item->user?->avatar
            ? asset($item->user->avatar)
            : asset('storage/img/placeholder-user.png');
    }

    public function imageIcon(): bool
    {
        return true;
    }

    private function actionMessage(Audit $audit): string
    {
        return match ($audit->event) {
            'created' => 'Cadastrou no sistema',
            'deleted' => 'Excluiu do sistema',
            'updated' => $this->updatedMessage($audit),
            default => $audit->event,
        };
    }

    private function actionColor(Audit $audit): string
    {
        return match ($audit->event) {
            'created' => 'success',
            'deleted' => 'danger',
            'updated' => 'warning',
            default => 'dark',
        };
    }

    private function updatedMessage(Audit $audit): string
    {
        $changes = $audit->getModified();

        if (empty($changes)) {
            return 'Editou sem mudanças';
        }

        $fields = collect($changes)
            ->keys()
            ->map(fn ($field) => "'{$field}'")
            ->join(', ');

        return "Editou o(s) campo(s): {$fields}";
    }

    public function columns(): array
    {
        return [
            ListViewColumn::make('user.nome')->label('Nome do autor'),
            ListViewColumn::make('event')->label('O que foi feito?')->format(function ($value, $item) use (&$statusCache) {
                $msg = $this->actionMessage($item);

                return $statusCache[$msg] ??= view('components.status', [
                    'color' => $this->actionColor($item),
                    'label' => $msg,
                ])->render();
            }),
            ListViewColumn::make('auditable.nome')->label('O que foi alterado?'),
            ListViewColumn::make('created_at')->label('Data')->format(fn ($value) => $value->format('d/m/Y H:i')),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('user')
                ->foreignKey('nome')
                ->label('Nome do autor'),

            ListViewFilter::make('event')
                ->label('Tipo de ação')
                ->type('multiselect')
                ->options([
                    'created' => 'Criação',
                    'updated' => 'Edição',
                    'deleted' => 'Exclusão',
                ]),

            ListViewFilter::make('created_at_start')
                ->label('Data inicial')
                ->size('small')
                ->type('date')
                ->startingDateInterval('created_at'),

            ListViewFilter::make('created_at_end')
                ->label('Data final')
                ->size('small')
                ->type('date')
                ->endingDateInterval('created_at'),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make('#'),
        ];
    }
}
