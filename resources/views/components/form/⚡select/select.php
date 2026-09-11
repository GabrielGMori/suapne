<?php

use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

new class extends Component
{
    #[Modelable]
    public array|string $selectedItems = [];

    #[Reactive]
    public array  $options       = [];

    public bool   $isMultiple    = false;
    public bool   $clearable     = false;
    public string $name          = '';
    public ?string $label        = null;
    public string $appearance    = 'default';
    public string $size          = 'medium';
    public string $noResultMessage = 'Sem resultados';

    #[Reactive]
    public ?string $placeholder  = '';

    #[Reactive]
    public ?bool   $disabled      = false;

    #[Reactive]
    public ?string $error        = null;

    public function mount(
        string  $type          = 'select',
        mixed   $value         = null,
        string  $name          = '',
        ?string $label         = null,
        string  $appearance    = 'default',
        string  $size          = 'medium',
        ?string $placeholder   = '',
        bool    $clearable     = false,
        bool    $disabled      = false,
        string $noResultMessage = 'Sem resultados',
        ?string $error         = null,
    ): void {
        $this->isMultiple    = $type === 'multiselect';
        $this->name          = $name;
        $this->label         = $label;
        $this->appearance    = $appearance;
        $this->size          = $size;
        $this->placeholder   = $placeholder;
        $this->clearable     = $clearable;
        $this->disabled      = $disabled;
        $this->noResultMessage = $noResultMessage;
        $this->error         = $error;

        $oldName = trim(preg_replace('/\[([^\]]*)\]/', '.$1', $name), '.');
        $resolved = $oldName !== '' ? old($oldName, $value) : $value;

        $this->selectedItems = $this->normalize($resolved);
    }

    public function updatedOptions($opt): void
    {
        $this->dispatch('updated-options', opt: $opt);
    }

    public function clear(): void
    {
        if ($this->disabled) return;

        $this->selectedItems = [];
    }

    #[On('select-all')]
    public function selectAll(string $name): void
    {
        if ($this->disabled || !$this->isMultiple || $this->name !== $name) return;

        $this->selectedItems = $this->normalize(array_keys($this->options));
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

    public function resolvedErrorName(): string
    {
        return preg_replace('/\[(.*?)\]/', '.$1', $this->name);
    }
};
