<?php

use App\View\Components\ListViewConfig;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

new class extends Component
{
    use WithPagination;

    public string $config;

    public ?string $title = null;
    public ?string $emptyMessage = null;
    public ?string $createUrl = null;
    public ?string $createLabel = null;

    public int $perPage = 15;
    public array $filtersState = [];

    private ?ListViewConfig $configInstance = null;

    protected function getConfigInstance(): ListViewConfig
    {
        return $this->configInstance ??= new ($this->config);
    }

    public function mount(): void
    {
        $config = $this->getConfigInstance();

        $this->perPage = $config->perPage();

        $this->title ??= $config->title();
        $this->createUrl ??= $config->createUrl();
        $this->createLabel ??= $config->createLabel();
        $this->emptyMessage ??= $config->emptyMessage();

        foreach ($config->filters() as $filter) {
            if (!isset($this->filtersState[$filter->getKey()])) {
                $isSelect = in_array($filter->getType(), ['select', 'multiselect']);
                $this->filtersState[$filter->getKey()] = $filter->getDefault() ?? ($isSelect ? [] : '');
            }
        }
    }

    public function updatedFiltersState(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $config = $this->getConfigInstance();

        foreach ($config->filters() as $filter) {
            $isSelect = in_array($filter->getType(), ['select', 'multiselect']);
            $this->filtersState[$filter->getKey()] = $filter->getDefault() ?? ($isSelect ? [] : '');
        }

        $this->resetPage();
    }

    public function getItemsProperty()
    {
        $config = $this->getConfigInstance();
        $query = $config->query();

        foreach ($config->filters() as $filter) {
            $value = $this->filtersState[$filter->getKey()] ?? null;

            if ($value === null || $value === '' || (is_array($value) && empty($value))) {
                continue;
            }

            $filter->apply($query, $value);
        }

        return $query->paginate($this->perPage);
    }
};