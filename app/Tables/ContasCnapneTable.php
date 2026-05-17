<?php

namespace App\Tables;

use App\Models\User;
use App\Support\FakeBuilder;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;

class ContasCnapneTable extends ListViewConfig
{
    private const SEED = [
        ['id' => 1, 'name' => 'Ana Carolina', 'email' => 'ana.carolina@exemplo.com', 'funcao' => 'Docente de Ed. Especial'],
        ['id' => 2, 'name' => 'Bruno Henrique Melo', 'email' => 'bruno.henrique@exemplo.com', 'funcao' => 'Técnico de Ed. Especial'],
        ['id' => 3, 'name' => 'Carla Beatriz Souza', 'email' => 'carla.beatriz@exemplo.com', 'funcao' => 'Docente de Ed. Especial'],
        ['id' => 4, 'name' => 'José Silva', 'email' => 'jose.silva@exemplo.com', 'funcao' => 'Técnico de Ed. Especial'],
        ['id' => 5, 'name' => 'Maria Souza', 'email' => 'maria.souza@exemplo.com', 'funcao' => 'Técnico de Ed. Especial'],
        ['id' => 6, 'name' => 'Pedro Santos', 'email' => 'pedro.santos@exemplo.com', 'funcao' => 'Docente de Ed. Especial'],
        ['id' => 7, 'name' => 'Maria Clara', 'email' => 'maria.clara@exemplo.com', 'funcao' => 'Técnico de Ed. Especial'],
        ['id' => 8, 'name' => 'João Pedro', 'email' => 'joao.pedro@exemplo.com', 'funcao' => 'Técnico de Ed. Especial'],
        ['id' => 9, 'name' => 'Pedro Santos', 'email' => 'pedro.santos@exemplo.com', 'funcao' => 'Técnico de Ed. Especial'],
    ];

    public function query(): Builder
    {
        return FakeBuilder::make(User::class, self::SEED);
    }

    // public function query(): Builder
    // {
    //     return User::query()->whereIn('funcao', ['Docente de Ed. Especial', 'Técnico de Ed. Especial']);
    // }

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
            ListViewFilter::make('name')->label('Nome')->size('large')->filterType('includes'),
            ListViewFilter::make('email')->label('E-mail')->size('large')->filterType('includes'),
            ListViewFilter::make('funcao')->label('Função')->type('select')
                ->options(['Docente de Ed. Especial', 'Técnico de Ed. Especial'])
                ->applyUsing(function($query, $value) {
                    $query->where('funcao', $value);
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
