<?php

use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\Attributes\Modelable;

new class extends Component {
    public ?string $label = null;
    public string $name = '';
    public string $type = 'text';
    public ?string $placeholder = null;

    #[Modelable]
    public mixed $value = null;
    public ?string $helper = null;
    public string $size = 'medium';
    public string $appearance = 'default';
    public ?string $mask = null;

    #[Reactive] 
    public ?string $error = null;

    public function mount(): void
    {
        if ($this->name !== '') {
            $this->value = old($this->name, $this->value);
        }
    }

    public function updatedValue($val): void
    {
        $this->dispatch('form-input-updated', name: $this->name, value: $val);
    }

    public function clear(): void
    {
        $this->value = null;
        $this->dispatch('form-input-updated', name: $this->name, value: null);
    }


    public function isTypePassword(): bool
    {
        return $this->type === 'password' || $this->type === 'password_forgot';
    }

    public function isTextarea(): bool
    {
        return $this->type === 'textarea';
    }

    public function resolvedType(): string
    {
        return match (true) {
            $this->type === 'datetime' => 'datetime-local',
            $this->isTypePassword() => 'password',
            default => $this->type,
        };
    }

    public function resolvedPlaceholder(): string
    {
        if ($this->placeholder !== null && $this->placeholder !== '') {
            return $this->placeholder;
        }

        return match (true) {
            $this->type === 'datetime' => 'DD/MM/AAAA 00:00',
            $this->type === 'date' => 'DD/MM/AAAA',
            default => '',
        };
    }

    public function resolvedClass(): string
    {
        $baseClass = trim("form-control form-control-{$this->appearance} form-control-{$this->size}");

        return match (true) {
            $this->isTextarea() => "{$baseClass} form-control-textarea",
            default => $baseClass,
        };
    }

    public function resolvedMask(): string
    {
        return match (true) {
            isset($this->mask) => trim($this->mask),
            $this->type === 'tel' => '+55 (99) 99999-9999',
            default => '',
        };
    }

    public function resolvedErrorName(): string
    {
        return preg_replace('/\[(.*?)\]/', '.$1', $this->name);
    }
};
