<?php

use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public string $config;

    public ?string $title = null;
    public ?string $emptyMessage = null;
    public bool|Closure $canCreate = true;
    public ?string $createUrl = null;
    public ?string $createLabel = null;
};
