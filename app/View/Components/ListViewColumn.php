<?php

namespace App\View\Components;

use Closure;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class ListViewColumn
{
    private ?string $label = null;
    private string $key;
    private string $size = 'medium';
    private ?Closure $format = null;

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

    public function size(string $size): static
    {
        $this->size = $size;
        return $this;
    }

    public function format(Closure $format): static
    {
        $this->format = $format;
        return $this;
    }

    public function link(Closure $href): static
    {
        $this->format = fn($value, $item) => view('components.link', ['label' => $value, 'href' => $href($item)]);
        return $this;
    }

    public function getKey(): string    { return $this->key; }
    public function getSize(): string   { return $this->size; }
    public function getLabel(): string  { return $this->label ??= Str::headline($this->key); }

    public function getFormattedValue(object $item): string|HtmlString
    {
        $value = data_get($item, $this->key);
        if ($this->format) {
            $result = ($this->format)($value, $item);
            return $result instanceof HtmlString ? $result : new HtmlString((string)$result);
        }
        return (string) $value;
    }
}
