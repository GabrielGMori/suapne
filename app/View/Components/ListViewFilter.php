<?php

namespace App\View\Components;

use Closure;
use Illuminate\Support\Facades\Blade;

use function PHPUnit\Framework\isArray;

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

    private ?Closure $applyUsing = null;
    private ?string $foreignKey = null;

    private function __construct(string $key)
    {
        $this->key = $key;
        $this->includes();
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

    public function applyUsing(Closure $closure): static
    {
        $this->applyUsing = $closure;
        return $this;
    }

    public function foreignKey(string $key): static
    {
        $this->foreignKey = $key;
        return $this;
    }

    public function applyOperationWithKey(string $useKey, string $operation, ?Closure $transform = null) : static
    {
        return $this->applyUsing(function ($query, $value) use ($useKey, $operation, $transform) {
            $isArray = is_array($value);
            $value = ($transform && !$isArray) ? $transform($value) : $value;

            if ($this->foreignKey) {
                $query->whereHas($useKey, fn($q) => $isArray
                    ? $q->whereIn($this->foreignKey, $value)
                    : $q->where($this->foreignKey, $operation, $value)
                );
            } else {
                $isArray
                    ? $query->whereIn($useKey, $value)
                    : $query->where($useKey, $operation, $value);
            }
        });
    }

    public function applyOperation(string $operation, ?Closure $transform = null): static
    {
        return $this->applyOperationWithKey($this->key, $operation, $transform);
    }

    public function equals(): static
    {
        return $this->applyOperation('=');
    }

    public function includes(): static
    {
        return $this->applyOperation('like', fn($value) => "%{$value}%");
    }

    public function apply(mixed $query, mixed $value): void
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
    }

    public function isHidden() : bool { return $this->hidden; }
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
            'default' => $this->default,
        ];
    }
}
