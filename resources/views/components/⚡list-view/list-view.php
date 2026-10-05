<?php

use App\View\Components\ListViewConfig;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;

new class extends Component {
    use WithPagination;

    public string $config;

    public ?string $modelClass = null;
    public ?string $tableName = null;
    public array $queryWheres = [];
    public array $queryBindings = [];
    public array $queryOrders = [];

    public ?string $title = null;
    public ?string $emptyMessage = null;
    public bool $canCreate = true;
    public ?string $createUrl = null;
    public ?string $createLabel = null;
    public bool $filtersExpanded = false;
    public ?string $filtersColor = null;

    public int $perPage = 10;

    #[Url(as: 'filter')]
    public array $filtersStates = [];

    public function getConfigInstance(): ListViewConfig
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

    public function mount(
        string $config,
        null|QueryBuilder|EloquentBuilder $query = null,
        ?bool $canCreate = null,
        ?string $title = null,
        ?string $emptyMessage = null,
        ?string $createUrl = null,
        ?string $createLabel = null,
        ?int $perPage = null,
        ?string $filtersColor = null
    ): void {
        $this->config = $config;
        $configInstance = $this->getConfigInstance();

        if ($query) {
            if ($query instanceof EloquentBuilder) {
                $this->modelClass = get_class($query->getModel());
                $rawQuery = $query->getQuery();
            } else {
                $this->tableName = $query->from;
                $rawQuery = $query;
            }

            $this->queryWheres = $rawQuery->wheres ?? [];
            $this->queryBindings = $rawQuery->getRawBindings() ?? [];
            $this->queryOrders = $rawQuery->orders ?? [];
        }

        $this->perPage = $perPage ?? $configInstance->perPage();
        $this->title = $title ?? $configInstance->title();
        $this->createUrl = $createUrl ?? $configInstance->createUrl();
        $this->createLabel = $createLabel ?? $configInstance->createLabel();
        $this->emptyMessage = $emptyMessage ?? $configInstance->emptyMessage();
        $this->filtersColor = $filtersColor;

        if ($canCreate !== null) {
            $this->canCreate = $canCreate;
        } else {
            $canCreateValue = $configInstance->canCreate();
            $this->canCreate = is_callable($canCreateValue) ? (bool) $canCreateValue() : (bool) $canCreateValue;
        }

        $this->filtersStates = array_merge(
            $this->buildDefaultFiltersStates(),
            $this->filtersStates
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

    #[Computed]
    public function baseQuery(): EloquentBuilder|QueryBuilder
    {
        if ($this->modelClass && class_exists($this->modelClass)) {
            $query = $this->modelClass::withoutGlobalScopes();

            if (! empty($this->queryWheres)) {
                $query->getQuery()->wheres = $this->queryWheres;

                foreach ($this->queryBindings as $type => $bindings) {
                    $query->getQuery()->setBindings($bindings, $type);
                }
            }

            if (! empty($this->queryOrders)) {
                $query->getQuery()->orders = $this->queryOrders;
            }

            return $query;
        }

        if ($this->tableName) {
            $query = \Illuminate\Support\Facades\DB::table($this->tableName);

            if (! empty($this->queryWheres)) {
                $query->wheres = $this->queryWheres;

                foreach ($this->queryBindings as $type => $bindings) {
                    $query->setBindings($bindings, $type);
                }
            }

            if (! empty($this->queryOrders)) {
                $query->orders = $this->queryOrders;
            }

            return $query;
        }

        return $this->getConfigInstance()->query();
    }

    #[Computed]
    public function items()
    {
        $query = clone $this->baseQuery;

        foreach ($this->getConfigInstance()->filters() as $filter) {
            $value = $this->filtersStates[$filter->getIdentifier() ?? $filter->getKey()] ?? null;

            if ($value === null || $value === '' || (is_array($value) && empty($value))) {
                continue;
            }

            $filter->apply($query, $value);
        }

        return $query->paginate($this->perPage);
    }

    #[Computed]
    public function urlFilters(): array
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
