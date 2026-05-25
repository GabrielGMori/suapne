<?php

namespace App\Tables;

use App\Enums\StatusPlanoTrabalhoEnum;
use App\Models\Curso;
use App\Models\Disciplina;
use App\Models\Estudante;
use App\Models\PlanoTrabalhoEstudante;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Illuminate\Database\Eloquent\Builder;

class PlanoTrabalhoEstudanteTable extends ListViewConfig
{
    public function query(): Builder
    {
        return PlanoTrabalhoEstudante::query();
    }
    public function title(): ?string { return 'Planos de Trabalho do Estudante'; }
    public function createUrl(): ?string { return route('planos-trabalho.form'); }
    public function createLabel(): ?string { return 'Criar Novo'; }
    public function emptyMessage(): string { return 'Nenhum plano de trabalho do estudante foi encontrado'; }
    public function icon(): string|\Closure { return "tune"; }

    public function columns(): array
    {
        $cache = [];

        return [
            ListViewColumn::make('estudante.nome')->label('Nome do estudante')->size("large"),
            ListViewColumn::make('disciplina.nome')->label('Componente curricular'),
            ListViewColumn::make('estudante.curso')->label('Curso')->size('large'),
            ListViewColumn::make('ano')->label('Ano')->size('small'),

           /* ListViewColumn::make('status')->label('Status')->format(
                function ($value, $item) use (&$statusCache) {
                    $label = gettype($value) === 'string' ? $value : $value->label();
                    return $statusCache[$label] ??= view('components.status', [
                        'label' => $label,
                        'color' => match($item->tipo) {
                            StatusPlanoTrabalhoEnum::Pendente => 'danger',
                            StatusPlanoTrabalhoEnum::Aguardando_revisao => 'warning',
                            StatusPlanoTrabalhoEnum::Aprovado => 'sucess',
                            StatusPlanoTrabalhoEnum::Devolvido => 'warning',
        
                        },
                    ])->render();
                    }),*/
        ];

        
    }

    public function filters(): array
    {
        return [
            ListViewFilter::make('estudante.nome')->label('Nome do estudante')->size('large'),
            ListViewFilter::make('ano')->label('Ano')->size('tiny'),
            
        ];
    }

    public function actions(): array
    {
        return [
            ListViewAction::make('#'),
        ];

        
    }

    

}
