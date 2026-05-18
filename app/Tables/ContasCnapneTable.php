<?php

namespace App\Tables;

use App\Enums\RoleEnum;
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
        return User::query()->whereIn('role', [RoleEnum::DOCENTE_ESPECIAL, RoleEnum::TECNICO], 'and', false);
    }

    public function title(): ?string { return 'Contas da CNAPNE registradas'; }
    public function emptyMessage(): string { return 'Nenhuma conta da CNAPNE foi encontrada.'; }
    public function perPage(): int { return 20; }
    public function imageIcon(): bool { return true; }
    public function icon(): string|\Closure { return asset('storage/img/placeholder-user.png'); }

    public function columns(): array
    {
        return [
            ListViewColumn::make('name')->label('Nome')->size('large'),
            ListViewColumn::make('email')->label('E-mail')->size('large'),
            ListViewColumn::make('role')->label('Função')->format(fn($value) => $value->label()),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nome')->label('Nome')->size('large'),
            ListViewFilter::make('email')->label('E-mail')->size('large'),
            ListViewFilter::make('role')->label('Função')->type('select')
                ->options([
                    RoleEnum::DOCENTE_ESPECIAL->value => RoleEnum::DOCENTE_ESPECIAL->label(), 
                    RoleEnum::TECNICO->value => RoleEnum::TECNICO->label()
                ])
                ->applyUsing(fn($query, $value) => $query->where('role', $value)),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make('#')->icon('edit'),
        ];
    }
}
