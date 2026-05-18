<?php

namespace App\Tables;

use App\Models\User;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;

class ContasCnapneTable extends ListViewConfig
{
    public function query(): Builder
    {
        return User::query()->whereIn('role', ['DOCENTE_ESPECIAL', 'TECNICO']);
    }

    public function title(): ?string { return 'Contas da CNAPNE registradas'; }
    public function createUrl(): ?string { return null; }
    public function createLabel(): ?string { return null; }
    public function emptyMessage(): string { return 'Nenhuma conta da CNAPNE foi encontrada.'; }
    public function perPage(): int { return 20; }
    public function imageIcon(): bool { return true; }
    public function icon(): string|\Closure { return asset('storage/img/placeholder-user.png'); }

    public function columns(): array
    {
        return [
            ListViewColumn::make('name')->label('Nome')->size('large'),
            ListViewColumn::make('email')->label('E-mail')->size('large'),
            ListViewColumn::make('funcao')->label('Função'),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nome')->label('Nome')->size('large')->filterType('includes'),
            ListViewFilter::make('email')->label('E-mail')->size('large')->filterType('includes'),
            ListViewFilter::make('funcao')->label('Função')->type('select')
                ->options(['Docente de Ed. Especial', 'Técnico de Ed. Especial'])
                ->applyUsing(function($query, $value) {
                    $role = $value === 'Docente de Ed. Especial' ? 'DOCENTE_ESPECIAL' : 'TECNICO';
                    $query->where('role', $role);
                }),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make('#')->icon('edit'),
        ];
    }
}
