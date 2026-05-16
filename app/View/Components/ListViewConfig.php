<?php

namespace App\View\Components;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

abstract class ListViewConfig
{
    abstract public function query(): QueryBuilder|EloquentBuilder;
    abstract public function columns(): array;

    public function filters(): array { return []; }
    public function actions(): array { return []; }
    public function icon(): string|\Closure { return 'description'; }
    public function imageIcon(): bool { return false; }
    public function perPage(): int { return 15; }
    public function title(): ?string { return null; }
    public function createUrl(): ?string { return null; }
    public function createLabel(): ?string { return null; }
    public function emptyMessage(): string { return 'Nada foi encontrado'; }
}
