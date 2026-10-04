<?php

namespace App\Tables;

use App\Enums\SituacaoEstudanteEnum;
use App\Enums\EtniaEnum;
use App\Enums\SexoEnum;
use App\Models\Curso;
use App\Models\Estudante;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewConfig;
use App\View\Components\ListViewFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EstudanteTable extends ListViewConfig
{
    public function query(): Builder
    {
        return Estudante::query()->latest();
    }

    public function title(): ?string
    {
        return 'Estudantes registrados';
    }

    public function canCreate(): bool
    {
        return Auth::user()->can('create', Estudante::class);
    }

    public function createUrl(): ?string
    {
        return route('estudantes.create');
    }

    public function createLabel(): ?string
    {
        return 'Cadastrar Novo';
    }

    public function emptyMessage(): string
    {
        return 'Nenhum estudante foi encontrado';
    }

    public function icon(): \Closure
    {
        return fn(Estudante $item) => $item->avatar
            ? asset($item->avatar)
            : asset('storage/img/placeholder-user.png');
    }

    public function imageIcon(): bool
    {
        return true;
    }

    public function columns(): array
    {
        $statusCache = [];

        return [
            ListViewColumn::make('nome')->label('Nome do estudante')->size('large')->link(fn($item) => route('estudantes.show', $item)),
            ListViewColumn::make('curso')->label('Curso do estudante')->size('large')->link(fn($item) => route('cursos.edit', $item->curso)),
            ListViewColumn::make('periodo')->label('Período')->size('small')->format(
                fn($value) => $value . '°'
            ),
            ListViewColumn::make('situacao')->label('Situação')->format(
                function ($value) use (&$statusCache) {
                    $label = $value instanceof SituacaoEstudanteEnum ? $value->label() : $value;
                    return $statusCache[$label] ??= view('components.status', [
                        'color' => 'dark',
                        'label' => $label,
                    ])->render();
                }
            ),
        ];
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('nome')->label('Nome do estudante')->size('large'),
            ListViewFilter::make('curso_id')->label('Curso do estudante')->size('large')->type('multiselect')->options(Curso::all()->pluck('nome', 'id')->toArray()),
            ListViewFilter::make('periodo')->label('Período')->size('tiny'),
            ListViewFilter::make('situacao')->label('Situação')->type('multiselect')->options(SituacaoEstudanteEnum::options()),
            ListViewFilter::make('matricula')->label('Matrícula')->hidden(),
            ListViewFilter::make('cpf')->label('CPF')->mask('999.999.999-99')->placeholder('000.000.000-00')->applyOperation('like', fn ($value)=> '%' . preg_replace('/\D/', '', $value). '%')->hidden(),
            ListViewFilter::make('data_nascimento')->label('Data de nascimento')->type('date')->hidden(),
            ListViewFilter::make('sexo')->label('Sexo')->size('small')->type('multiselect')->options(SexoEnum::options())->hidden(),
            ListViewFilter::make('etnia')->label('Etnia')->type('multiselect')->options(EtniaEnum::options())->hidden(),
            ListViewFilter::make('nacionalidade')->label('Nacionalidade')->hidden(),
            ListViewFilter::make('naturalidade')->label('Naturalidade')->hidden(),
            ListViewFilter::make('nome_mae')->label('Nome da mãe')->hidden(),
            ListViewFilter::make('nome_pai')->label('Nome do pai')->hidden(),
            ListViewFilter::make('nome_responsavel')->label('Nome do responsável')->hidden(),
            ListViewFilter::make('excluido')->trashed(),
            
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make(static fn(Estudante $item) => route('estudantes.show', ['estudante' => $item]))
                ->restoreOnTrashed(static fn(Estudante $item) => route('estudantes.restore', ['estudante' => $item]), 'Deseja restaurar este estudante?'),
        ];
    }
}
