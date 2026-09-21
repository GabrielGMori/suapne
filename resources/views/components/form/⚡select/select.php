<?php

use Livewire\Component;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;

new class extends Component
{
    #[Modelable]
    public array|string|int|null $selectedItems = [];

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
        $this->selectedItems = $this->normalize($this->resolveInitialValue($name, $value));
    }

    public function updatedSelectedItems($value): void
    {
        if (!is_array($value)) {
            $this->selectedItems = $this->normalize($value);
        }
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

    public function resolvedErrorName(): string
    {
        return $this->dotName($this->name);
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

    private function normalize(mixed $value): array
    {
        if (is_array($value)) {
            return array_values(array_map('strval', array_filter($value, fn($v) => $v !== '' && $v !== null)));
        }

        if ($value !== null && $value !== '') {
            return [strval($value)];
        }

        return [];
    }
};
