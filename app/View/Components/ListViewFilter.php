<?php

namespace App\View\Components;

use Closure;
use Illuminate\Support\Facades\Blade;

class ListViewFilter implements \JsonSerializable
{
    private string $key;
    private ?string $label = null;
    private string $type = 'text';
    private string $size = 'medium';
    private mixed $default = '';
    private array $options = [];
    private bool $clearable = true;
    private ?string $placeholder = null;
    private bool $hidden = false;
    private string $filterType = 'includes';
    private ?string $identifier = null;

    private ?Closure $applyUsing = null;

    private function __construct(string $key)
    {
        $this->key = $key;
    }

    public static function make(string $key): static
    {
        return new static($key);
    }

    public function label(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function type(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function size(string $size): static
    {
        $this->size = $size;
        return $this;
    }

    public function default(mixed $default): static
    {
        $this->default = $default;
        return $this;
    }

    public function options(array $options): static
    {
        $this->options = $options;
        return $this;
    }

    public function clearable(bool $clearable = true): static
    {
        $this->clearable = $clearable;
        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function hidden(): static
    {
        $this->hidden = true;
        return $this;
    }

    public function filterType(string $filterType): static
    {
        $this->filterType = $filterType;
        return $this;
    }

    public function identifier(string $identifier): static
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function applyUsing(Closure $closure): static
    {
        $this->applyUsing = $closure;
        return $this;
    }

    public function apply($query, mixed $value): void
    {
        if (isset($this->applyUsing)) {
            ($this->applyUsing)($query, $value);
            return;
        }

        if (is_array($value)) {
            if (empty($value)) return;
            $query->whereIn($this->key, $value);
            return;
        }

        match ($this->filterType) {
            'includes' => $query->where($this->key, 'like', "%{$value}%"),
            'equals'   => $query->where($this->key, $value),
            default    => null,
        };
    }

    public function isHidden() : bool { return $this->hidden; }
    public function getFilterType(): string { return $this->filterType; }
    public function getIdentifier(): ?string { return $this->identifier; }
    public function getKey(): string        { return $this->key; }
    public function getLabel(): string      { return $this->label ?? \Illuminate\Support\Str::headline($this->key); }
    public function getType(): string       { return $this->type; }
    public function getSize(): string       { return $this->size; }
    public function getDefault(): mixed     { return $this->default; }
    public function getOptions(): array     { return $this->options; }
    public function getPlaceholder(): ?string { return $this->placeholder; }
    public function isClearable(): bool { return $this->clearable; }

    public function jsonSerialize(): array
    {
        return [
            'key' => $this->key,
            'identifier' => $this->identifier,
            'default' => $this->default,
            'filterType' => $this->filterType,
        ];
    }
}
