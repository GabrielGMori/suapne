<?php

namespace App\Tables;

use App\Models\ObservacaoEstudante;
use App\View\Components\ListViewColumn;
use App\View\Components\ListViewFilter;
use App\View\Components\ListViewAction;
use App\View\Components\ListViewConfig;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use App\Models\AtendimentoSemanal;
use Illuminate\Database\Eloquent\SoftDeletes;
use Litvinjuan\LaravelCascadeSoftDeletes\CascadeSoftDeletes;

class ObservacaoEstudanteTable extends ListViewConfig
{
    public function query(): Builder
    {
        return ObservacaoEstudante::query()->orderBy('created_at', 'desc');
    }

    public function title(): ?string { return 'Observações'; }
    public function createUrl(): ?string { return null; }
    public function createLabel(): ?string { return null; }
    public function emptyMessage(): string { return 'Nenhuma observação foi encontrada'; }
    public function icon(): string|Closure { return null; }

    public function columns(): array
    {
        return [];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [];
    }

}
