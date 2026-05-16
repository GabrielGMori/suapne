<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

class ListView extends Component
{
    /**
     * Create a new component instance.
     * @param string|null                $title     Título exibido no cabeçalho do card.
     * @param array|Collection|Paginator $items     Lista de models a serem listados.
     * @param ListViewColumn[] $columns             Colunas a serem mostradas
     * @param string|Closure             $icon      Ícone de cada item. Pode ser uma função que retorna uma string.
     * @param bool                       $imageIcon Se true, renderiza $icon como <img> em vez de <x-icon>.
     * @param string                     $emptyMessage Mensagem exibida quando $items está vazio.
     * @param string|null                $createUrl URL do botão criar.
     * @param string|null                $createLabel Label do botão criar.
     * @param ListViewAction[]|null $actions        Botões de ações no canto direito de cada item.
     * @param ListViewFilter[]|null $filters        Filtros acima da list-view.
     */
    public function __construct(
        public ?string $title = null,
        public array|Collection|Paginator $items = [],
        public array $columns = [],

        public string|Closure $icon = 'description',
        public bool $imageIcon = false,

        public string $emptyMessage = 'Nada foi encontrado',

        public ?string $createUrl = null,
        public ?string $createLabel = null,

        public ?array $actions = null,

        public ?array $filters = null,
    ) {}

    public function hasPagination(): bool
    {
        return $this->items instanceof Paginator;
    }

    public function hasHiddenFilters() : bool
    {
        return collect($this->filters)->contains(fn($filter) => $filter->isHidden());
    }

    public function renderFilters(bool $hidden = false): HtmlString
    {
        $filters = collect($this->filters)->filter(fn($filter) => $filter->isHidden() == $hidden);

        $html = $filters->map(function($filter) {
            return Blade::render(
                '<x-form-input
                    :name="$name"
                    :label="$label"
                    :type="$type"
                    :value="$default"
                    :options="$options"
                    :clearable="$clearable"
                    :size="$size"
                    :placeholder="$placeholder"
                    appearance="outlined"
                />',
                [
                    'name'        => $filter->getKey(),
                    'label'       => $filter->getLabel(),
                    'type'        => $filter->getType(),
                    'default'     => $filter->getDefault(),
                    'options'     => $filter->getOptions(),
                    'clearable'   => $filter->isClearable(),
                    'size'        => $filter->getSize(),
                    'placeholder' => $filter->getPlaceholder(),
                ]
            );
        })->join('');

        return new HtmlString($html);
    }


    public function render(): View|Closure|string
    {
        return view('components.list-view');
    }
}
