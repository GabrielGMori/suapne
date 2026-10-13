<?php

use Livewire\Component;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

/**
 * Reusable select / multiselect.
 *
 * Model contract (what the parent receives through wire:model):
 *  - type="select"      => ?string          (null when nothing is selected)
 *  - type="multiselect" => array<int,string>
 *
 * The parent's property and this component's $selectedItems are kept in sync by
 * Alpine's x-modelable, so both sides MUST share the same shape. Never coerce the
 * bound value into another shape on the parent side.
 */
new class extends Component
{
    #[Modelable]
    public array|string|null $selectedItems = null;

    #[Reactive]
    public array $options = [];

    public bool $isMultiple = false;
    public bool $clearable = false;
    public string $name = '';
    public ?string $label = null;
    public string $appearance = 'default';
    public string $size = 'medium';
    public string $noResultMessage = 'Sem resultados';

    #[Reactive]
    public ?string $placeholder = '';

    #[Reactive]
    public ?bool $disabled = false;

    #[Reactive]
    public ?string $parentError = null;

    public function mount(
        string $type = 'select',
        mixed $value = null,
        string $name = '',
        ?string $label = null,
        string $appearance = 'default',
        string $size = 'medium',
        ?string $placeholder = '',
        bool $clearable = false,
        bool $disabled = false,
        string $noResultMessage = 'Sem resultados',
        ?string $parentError = null,
    ): void {
        $this->fill(compact(
            'name',
            'label',
            'appearance',
            'size',
            'placeholder',
            'clearable',
            'disabled',
            'noResultMessage',
            'parentError',
        ));

        $this->isMultiple = $type === 'multiselect';

        // When bound through wire:model, Livewire has already filled $selectedItems
        // with the parent's value; otherwise fall back to old() / the "value" prop.
        $initial = filled($this->selectedItems) ? $this->selectedItems : $this->resolveInitialValue($name, $value);
        $this->selectedItems = $this->normalize($initial);
    }

    public function updatedSelectedItems(mixed $value): void
    {
        $this->selectedItems = $this->normalize($value);
    }

    public function updatedOptions(): void
    {
        $this->dispatch('select-options-updated', options: $this->optionList())->self();
    }

    public function clear(): void
    {
        if ($this->disabled) return;

        $this->selectedItems = $this->normalize(null);
    }

    #[On('select-all')]
    public function selectAll(string $name): void
    {
        if ($this->disabled || !$this->isMultiple || $this->name !== $name) return;

        $this->selectedItems = $this->normalize(array_keys($this->options));
    }

    public function resolvedErrorName(): string
    {
        return $this->dotName($this->name);
    }

    /**
     * Options as an ordered list of {value, label}.
     *
     * Sending a list (instead of the raw associative array) preserves the server-side
     * ordering: JS objects always iterate integer-like keys in ascending order, which
     * would otherwise reorder e.g. students sorted by name into "sorted by id".
     */
    public function optionList(): array
    {
        $list = [];

        foreach ($this->options as $value => $label) {
            if ($label === null) continue;
            $list[] = ['value' => (string) $value, 'label' => (string) $label];
        }

        return $list;
    }

    private function resolveInitialValue(string $name, mixed $value): mixed
    {
        $dotName = $this->dotName($name);
        return $dotName !== '' ? old($dotName, $value) : $value;
    }

    private function dotName(string $name): string
    {
        return trim(preg_replace('/\[([^\]]*)\]/', '.$1', $name), '.');
    }

    /**
     * Coerce any input into the shape dictated by the model contract.
     */
    private function normalize(mixed $value): array|string|null
    {
        $values = array_values(array_map(
            'strval',
            array_filter((array) $value, fn($v) => $v !== '' && $v !== null && !is_array($v)),
        ));

        return $this->isMultiple ? $values : ($values[0] ?? null);
    }
};
