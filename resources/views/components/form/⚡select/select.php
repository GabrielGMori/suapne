<?php

use Livewire\Component;
use Livewire\Attributes\Modelable;

new class extends Component
{
    #[Modelable]
    public string|array $selectedItems = [];

    public array   $options     = [];
    public bool    $isMultiple  = false;
    public bool    $clearable   = false;
    public string  $name        = '';
    public ?string $label       = null;
    public string  $appearance  = 'default';
    public string  $size        = 'medium';
    public ?string  $placeholder = '';

    public function mount(
        string  $type        = 'select',
        array   $options     = [],
        mixed   $value       = null,
        string  $name        = '',
        ?string $label       = null,
        string  $appearance  = 'default',
        string  $size        = 'medium',
        ?string  $placeholder = '',
        bool    $clearable   = false,
    ): void {
        $this->isMultiple  = $type === 'multiselect';
        $this->options     = array_values(array_map('strval', $options));
        $this->name        = $name;
        $this->label       = $label;
        $this->appearance  = $appearance;
        $this->size        = $size;
        $this->placeholder = $placeholder;
        $this->clearable   = $clearable;

        $oldName  = $this->isMultiple ? rtrim($name, '[]') : $name;
        $resolved = ($oldName !== '') ? old($oldName, $value) : $value;

        if (is_array($resolved)) {
            $this->selectedItems = array_values(array_map('strval', $resolved));
        } elseif ($resolved !== null && $resolved !== '') {
            $this->selectedItems = [(string) $resolved];
        } else {
            $this->selectedItems = [];
        }
    }



    public function clear(): void
    {
        $this->selectedItems = [];
        $this->dispatch('form-input-updated', name: $this->name, value: $this->isMultiple ? [] : '');
    }

    public function updatedSelectedItems(): void
    {
        if (is_string($this->selectedItems)) {
            $this->selectedItems = $this->selectedItems !== '' ? [$this->selectedItems] : [];
        }

        $value = $this->isMultiple
            ? $this->selectedItems
            : ($this->selectedItems[0] ?? '');

        $this->dispatch('form-input-updated', name: $this->name, value: $value);
    }
};