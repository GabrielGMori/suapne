<?php

namespace App\View\Components;
use Closure;

class ListViewAction
{
    private string|Closure $url;
    private ?string $method = null;
    private string $icon    = 'open_in_new';
    private string $color   = 'transparent';
    private bool $confirm   = false;

    private function __construct(string|Closure $url)
    {
        $this->url = $url;
    }

    public static function make(string|Closure $url): static
    {
        return new static($url);
    }

    public function method(string $method): static
    {
        $this->method = strtoupper($method);
        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function color(string $color): static
    {
        $this->color = $color;
        return $this;
    }

    public function confirm(): static
    {
        $this->confirm = true;
        return $this;
    }

    public function isLink(): bool        { return $this->method === null; }
    public function needsDirective(): bool { return !in_array($this->method, ['GET', 'POST', null]); }

    public function getUrl(object $item): string { return is_callable($this->url) ? ($this->url)($item) : $this->url; }
    public function getMethod(): ?string        { return $this->method; }
    public function getIcon(): string           { return $this->icon; }
    public function getColor(): string          { return $this->color; }
    public function getConfirm(): bool          { return $this->confirm; }
}
