<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class ListView extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $title = null,
        public array|Collection $items = [],
        public array $columns = [],

        public string|Closure $icon = "description",
        public bool $imageIcon = false,

        public string $emptyMessage = "Nada foi encontrado",

        public ?string $createUrl = null,
        public ?string $createLabel = null,

        public ?array $actions = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.list-view');
    }
}
