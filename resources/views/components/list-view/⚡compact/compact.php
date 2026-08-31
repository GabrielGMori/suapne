<?php

namespace App\Livewire\ListView;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use App\View\Components\ListViewConfig;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

new class extends Component
{
    use WithPagination;

    public string $config;
    public Collection $items;

    public string $search = '';
    public bool $asDocument = false;
    public ?string $groupBy = null;
    public bool $hasSearch = false;
    public int $perPage = 10;
    public array $filtersStates = [];

    protected function getConfigInstance(): ListViewConfig
    {
        return new ($this->config);
    }

    public function mount(): void
    {
        $cfg = $this->getConfigInstance();
        $this->perPage = $cfg->perPage();
    }

    public function updatedSearch(): void
    {
        $this->loadedPages = 1;
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->loadedPages = 1;
        $this->resetPage();
    }

    public int $loadedPages = 1;

    public function loadMore(): void
    {
        if ($this->hasMoreItems()) {
            $this->loadedPages++;
            unset($this->items);
        }
    }

    #[On('observacao-added')]
    #[On('compact-list-refresh')]
    public function refreshList(): void
    {
        $this->loadedPages = 1;
        unset($this->items);
    }

    protected function getItemsQuery()
    {
        $cfg = $this->getConfigInstance();
        $query = $cfg->query();

        if ($this->search !== '' && !empty($cfg->searchableColumns())) {
            $searchTerm = '%' . $this->search . '%';
            $searchColumns = $cfg->searchableColumns();

            $query->where(function ($q) use ($searchColumns, $searchTerm) {
                foreach ($searchColumns as $column) {
                    if (str_contains($column, '.')) {
                        $parts = explode('.', $column, 2);
                        $q->orWhereHas($parts[0], fn($sub) => $sub->where($parts[1], 'like', $searchTerm));
                    } else {
                        $q->orWhere($column, 'like', $searchTerm);
                    }
                }
            });
        }

        foreach ($cfg->filters() as $filter) {
            $value = $this->filtersStates[$filter->getIdentifier() ?? $filter->getKey()] ?? null;

            if ($value === null || $value === '' || (is_array($value) && empty($value))) {
                continue;
            }

            $filter->apply($query, $value);
        }

        return $query;
    }

    public function hasMoreItems(): bool
    {
        $cfg = $this->getConfigInstance();

        return $cfg->loadMore()
            && $this->getItemsQuery()->count() > $this->loadedPages * $this->perPage;
    }

    #[Computed]
    public function items(): Collection|LengthAwarePaginator
    {
        if ($this->customView) {
            return collect();
        }

        $cfg = $this->getConfigInstance();
        $query = $this->getItemsQuery();

        if ($cfg->loadMore()) {
            return $query->limit($this->loadedPages * $this->perPage)->get();
        }

        // Grouping doesn't work well with pagination, so use get() for grouped data
        if ($this->groupBy) {
            return $query->get()->groupBy($this->groupBy);
        }

        return $query->paginate($this->perPage);
    }
};
