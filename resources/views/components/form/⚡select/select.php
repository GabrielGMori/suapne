<?php

use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Modelable;

new class extends Component
{
    #[Modelable]
    public array|string $selectedItems = [];

    public array  $options       = [];
    public bool   $isMultiple    = false;
    public bool   $clearable     = false;
    public string $name          = '';
    public ?string $label        = null;
    public string $appearance    = 'default';
    public string $size          = 'medium';
    public ?string $placeholder  = '';
    public bool   $dispatchEvent = true;

    public function mount(
        string  $type          = 'select',
        array   $options       = [],
        mixed   $value         = null,
        string  $name          = '',
        ?string $label         = null,
        string  $appearance    = 'default',
        string  $size          = 'medium',
        ?string $placeholder   = '',
        bool    $clearable     = false,
        bool    $dispatchEvent = true,
    ): void {
        $this->isMultiple    = $type === 'multiselect';
        $this->name          = $name;
        $this->label         = $label;
        $this->appearance    = $appearance;
        $this->size          = $size;
        $this->placeholder   = $placeholder;
        $this->clearable     = $clearable;
        $this->dispatchEvent = $dispatchEvent;

        // Preserve key => label pairs as [{value, label}] objects for Alpine
        $this->options = collect($options)
            ->map(fn($label, $key) => ['value' => (string) $key, 'label' => (string) $label])
            ->values()
            ->all();

        $baseName = rtrim($name, '[]');
        $resolved = ($value !== null && $value !== '')
            ? $value
            : (($baseName !== '') ? old($baseName) : null);

        $this->selectedItems = $this->normalize($resolved);
    }

    public function updatedSelectedItems(): void
    {
        $this->selectedItems = $this->normalize($this->selectedItems);
        $this->emitChange();
    }

    public function clear(): void
    {
        $this->selectedItems = [];
        $this->emitChange();
    }

    private function normalize(mixed $value): array
    {
        if (is_array($value)) {
            return array_values(array_map('strval', array_filter($value, fn($v) => $v !== '')));
        }

        if ($value !== null && $value !== '') {
            return [strval($value)];
        }

        return [];
    }

    private function emitChange(): void
    {
        if (! $this->dispatchEvent) return;

        $value = $this->isMultiple
            ? $this->selectedItems
            : ($this->selectedItems[0] ?? '');

        $this->dispatch('form-input-updated', name: $this->name, value: $value);
    }

    public function resolvedErrorName(): string
    {
        return preg_replace('/\[(.*?)\]/', '.$1', $this->name);
    }
};
