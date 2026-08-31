<?php

namespace App\View\Components;

use Illuminate\Database\Eloquent\Builder;
use Closure;

abstract class ListViewConfig
{
    abstract public function query(): Builder;
    abstract public function columns(): array;

    public function filters(): array { return []; }
    public function actions(): array { return []; }
    public function icon(): string|Closure { return 'description'; }
    public function imageIcon(): bool { return false; }
    public function perPage(): int { return 10; }
    public function loadMore(): bool { return false; }
    public function title(): ?string { return null; }
    public function canCreate(): bool|Closure { return true; }
    public function createUrl(): ?string { return null; }
    public function createLabel(): ?string { return null; }
    public function createLivewireComponent(): ?string { return null; }
    public function searchableColumns(): array { return []; }
    public function emptyMessage(): string { return 'Nada foi encontrado'; }
}
