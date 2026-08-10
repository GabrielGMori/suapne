<?php

use App\View\Components\ListViewConfig;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

new class extends Component {
    use WithPagination;

    public string $config;

    public ?string $title = null;
    public ?string $emptyMessage = null;
    public bool|Closure $canCreate = true;
    public ?string $createUrl = null;
    public ?string $createLabel = null;
    public bool $filtersExpanded = false;

    public int $perPage = 10;

    #[Url(as: 'filter')]
    public array $filtersStates = [];

    protected function getConfigInstance(): ListViewConfig
    {
        return new ($this->config);
    }

    private function buildDefaultFiltersStates(): array
    {
        return collect($this->getConfigInstance()->filters())
            ->mapWithKeys(fn($filter) => [
                ($filter->getIdentifier() ?? $filter->getKey()) => $filter->getDefault() ??
                    (in_array($filter->getType(), ['select', 'multiselect']) ? [] : null),
            ])
            ->toArray();
    }

    public function mount(): void
    {
        $config = $this->getConfigInstance();
        $this->perPage = $config->perPage();
        $this->title = $config->title();
        $this->canCreate = $config->canCreate();
        $this->createUrl = $config->createUrl();
        $this->createLabel = $config->createLabel();
        $this->emptyMessage = $config->emptyMessage();

        $this->filtersStates = array_merge(
            $this->buildDefaultFiltersStates(),
            $this->filtersStates,
        );
    }

    public function clearFilters(): void
    {
        $this->filtersStates = $this->buildDefaultFiltersStates();
        $this->resetPage();
    }

    public function updatedFiltersStates(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function getItemsProperty()
    {
        $config = $this->getConfigInstance();
        $query = $config->query();

        foreach ($config->filters() as $filter) {
            $value = $this->filtersStates[$filter->getIdentifier() ?? $filter->getKey()] ?? null;

            if ($value === null || $value === '' || (is_array($value) && empty($value))) {
                continue;
            }

            $filter->apply($query, $value);
        }

        return $query->paginate($this->perPage);
    }

    public function getUrlFiltersProperty(): array
    {
        return collect($this->filtersStates)
            ->filter(
                fn($value) =>
                $value !== null &&
                $value !== '' &&
                (!is_array($value) || !empty($value))
            )
            ->toArray();
    }
};
