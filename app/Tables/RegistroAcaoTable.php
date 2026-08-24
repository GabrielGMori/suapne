<?php

namespace App\Tables;

use App\Models\Estudante;
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
            ->where('auditable_type', Estudante::class)
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
            'created' => 'Criou o estudante',
            'deleted' => 'Excluiu o estudante',
            'updated' => $this->updatedMessage($audit),
            default => $audit->event,
        };
    }

    private function updatedMessage(Audit $audit): string
    {
        $changes = $audit->getModified();

        if (empty($changes)) {
            return 'Editou o estudante';
        }

        $fields = collect($changes)
            ->keys()
            ->map(fn ($field) => "'{$field}'")
            ->join(', ');

        return "Editou campo {$fields}";
    }

    public function columns(): array
    {
        return [
            ListViewColumn::make('user.nome')
                ->label('Nome do autor'),

            ListViewColumn::make('auditable.nome')
                ->label('Estudante alterado'),

            ListViewColumn::make('created_at')
                ->label('Data')
                ->format(
                    fn ($value) => $value->format('d/m/Y H:i')
                ),

            ListViewColumn::make('event')->label('Ação')->format(fn ($value, $item) => $this->actionMessage($item)),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('user')
                ->foreignKey('nome')
                ->label('Nome do autor'),

            ListViewFilter::make('auditable')
                ->foreignKey('nome')
                ->label('Nome do estudante'),

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

            ListViewFilter::make('event')
                ->label('Tipo de ação')
                ->type('multiselect')
                ->options([
                    'created' => 'Criação',
                    'updated' => 'Edição',
                    'deleted' => 'Exclusão',
                ]),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make('#'),
        ];
    }
}
