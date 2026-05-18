<?php

use Livewire\Component;
use Livewire\Attributes\Modelable;

new class extends Component
{
    #[Modelable]
    public string|array $selectedItems = [];

    public array   $options       = [];
    public bool    $isMultiple    = false;
    public bool    $clearable     = false;
    public string  $name          = '';
    public ?string $label         = null;
    public string  $appearance    = 'default';
    public string  $size          = 'medium';
    public ?string $placeholder   = '';
    public bool    $dispatchEvent = true;

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
        $this->options       = array_values(array_map('strval', $options));
        $this->name          = $name;
        $this->label         = $label;
        $this->appearance    = $appearance;
        $this->size          = $size;
        $this->placeholder   = $placeholder;
        $this->clearable     = $clearable;
        $this->dispatchEvent = $dispatchEvent;

        $baseName = rtrim($name, '[]');
        $resolved = ($value !== null && $value !== '')
            ? $value
            : (($baseName !== '') ? old($baseName) : null);

        $this->selectedItems = $this->normalize($resolved);
    }

    public function clear(): void
    {
        $this->selectedItems = [];
        $this->emitChange();
    }

    public function updatedSelectedItems(): void
    {
        $this->emitChange();
    }

    private function normalize(mixed $value): array
    {
        if (is_array($value)) {
            return array_values(array_map('strval', $value));
        }

        if (is_string($value) && $value !== '') {
            return [$value];
        }

        return [];
    }

    private function emitChange(): void
    {
        if (! $this->dispatchEvent) {
            return;
        }

        $value = $this->isMultiple
            ? $this->selectedItems
            : ($this->selectedItems[0] ?? '');

        $this->dispatch('form-input-updated', name: $this->name, value: $value);
    }
};
