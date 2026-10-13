<?php

namespace App\Tables;

use App\Enums\RoleEnum;
use App\Enums\StatusPlanoTrabalhoEnum;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\PlanoTrabalhoEstudante;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
class PlanoTrabalhoEstudanteTable extends ListViewConfig
{
    public function query(): Builder
    {
        $query = PlanoTrabalhoEstudante::query()->orderBy('status')->latest();
        $user = Auth::user();
        $query = $user->role === RoleEnum::PROFESSOR_REGULAR ? $query->where('user_professor_id', $user->id) : $query;
        return $query;
    }
    public function title(): ?string {
        return (Auth::user()->role === RoleEnum::PROFESSOR_REGULAR ? 'Meus ' : '') . 'Planos de Trabalho do Estudante';
    }
    public function canCreate(): bool { return Auth::user()->can('create', PlanoTrabalhoEstudante::class); }
    public function createUrl(): ?string { return route('planos-trabalho.create'); }
    public function createLabel(): ?string { return 'Criar Novo'; }
    public function emptyMessage(): string { return 'Nenhum plano de trabalho do estudante foi encontrado'; }
    public function icon(): string|\Closure { return "assignment"; }

    public function columns(): array
    {
        $cache = [];

        return [
            ListViewColumn::make('estudante.nome')->label('Nome do estudante')->format(function ($value, $item) {
                $label = (string) $value;
                if ($item->estudante && $item->estudante->trashed()) {
                    $label .= ' (Excluído)';
                    return $label;
                }

                return $item->estudante
                    ? view('components.link', ['label' => $label, 'href' => route('estudantes.show', $item->estudante)])->render()
                    : $label;
            }),
            ListViewColumn::make('disciplina.nome')->label('Componente curricular')->link(fn($item) => $item->disciplina ? route('disciplinas.edit', $item->disciplina) : ''),
            ListViewColumn::make('disciplina.curso')->label('Curso')->link(fn($item) => $item->trashed() || ! $item->estudante || $item->estudante->trashed() || ! $item->estudante?->curso ? null : route('cursos.edit', $item->estudante->curso)),
            ListViewColumn::make('ano')->label('Ano')->size('small'),
            ListViewColumn::make('status')->label('Status')->size('small')->format(
                function ($value) use (&$statusCache) {
                    $label = gettype($value) === 'string' ? $value : $value->label();
                    return $statusCache[$label] ??= view('components.status', [
                        'label' => $value->badgeLabel(),
                        'color' => $value->color(),
                    ])->render();
                }
            ),
        ];


    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('estudante')->foreignKey('nome')->label('Nome do estudante')->size('large'),
            ListViewFilter::make('disciplina_id')->label('Componente curricular')->size('xlarge')->type('multiselect')
                ->options(Disciplina::with('curso')->get()->mapWithKeys(fn(Disciplina $d) => [$d->id => $d->nome . ($d->curso ? " - {$d->curso->nome}" : '')])->toArray()),
            ListViewFilter::make('disciplina')->foreignKey('curso_id')->label('Curso')->size('large')->type('select')->equals()
                ->options(Curso::pluck('nome', 'id')->toArray()),
            ListViewFilter::make('professor')->foreignKey('nome')->label('Docente')->size('large'),
            ListViewFilter::make('ano')->label('Ano')->size('tiny')
                ->applyUsing(fn(Builder $query, string $value) => $query->whereYear('periodo_inicio', $value)),
            ListViewFilter::make('status')->label('Status')->size('small')->type('multiselect')->options(StatusPlanoTrabalhoEnum::options())->equals(),
            ListViewFilter::make('user')->foreignKey('nome')->label('Criado por')->size('large')->hidden(),
            ListViewFilter::make('periodo_inicio')->label('Início do período')->type('date')->size('small')->hidden(),
            ListViewFilter::make('periodo_fim')->label('Fim do período')->type('date')->size('small')->hidden(),
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make(static fn(PlanoTrabalhoEstudante $item) => route('planos-trabalho.show', ['planoTrabalho' => $item]))
                ->restoreOnTrashed(static fn(PlanoTrabalhoEstudante $item) => route('planos-trabalho.restore', ['planoTrabalho' => $item]), 'Deseja restaurar este PTE?'),
        ];
    }
}
