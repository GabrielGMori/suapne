<?php

namespace App\Tables;

use App\Enums\RoleEnum;
use App\Models\Disciplina;
use App\Models\User;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;

class ContasProfessorTable extends ListViewConfig
{
    public function query(): Builder
    {
         return User::query()->where('role', RoleEnum::PROFESSOR_REGULAR)->with('disciplinas.curso')->latest();
    }

    public function title(): ?string { return 'Professores registrados'; }
    public function emptyMessage(): string { return 'Nenhum professor foi encontrado.'; }
    public function imageIcon(): bool { return true; }
    public function icon(): string|\Closure { return fn($item) => $item->avatar
            ? asset($item->avatar)
            : asset('storage/img/placeholder-user.png');
    }

    public function columns(): array
    {
        return [
            ListViewColumn::make('name')->label('Nome do professor')->size('large')->link(fn($item) => route('contas.professor.edit', $item)),
            ListViewColumn::make('email')->label('E-mail do professor')->size('large'),
            ListViewColumn::make('disciplinas')->label('Disciplinas')
            ->format(fn($value) => $value->count() > 0 ? view('components.modal.simple-text', [
                'label' => 'Ver disciplinas',
                'title' => 'Disciplinas',
                'value' => $value->map(fn($disciplina) => "• {$disciplina->nome} - {$disciplina->curso->nome}")->toArray()
            ])->render() : '---'),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nome')->label('Nome do professor'),
            ListViewFilter::make('email')->label('E-mail do professor')->size('large'),
            ListViewFilter::make('disciplinas')->foreignKey('disciplinas.id')->label('Disciplinas')->size('xlarge')->type('multiselect')->equals()
                ->options(Disciplina::all()->mapWithKeys(fn(Disciplina $disciplina) => [$disciplina->id => "{$disciplina->nome} - {$disciplina->curso->nome}"])->toArray()),
        ];
    }

    public function actions(): array
    {
        return [
           ListViewAction::make(static fn(User $item) => route('contas.professor.edit', $item))->icon('edit'),
        ];
    }
}
