<?php

namespace App\View\Components;
use Closure;
use function in_array;

class ListViewAction
{
    private string|Closure $url;
    private string|Closure|null $method = null;
    private string|Closure $icon    = 'open_in_new';
    private string|Closure $color   = 'transparent';
    private bool|Closure $confirm   = false;
    private string $confirmMessage = '';

    private function __construct(string|Closure $url)
    {
        $this->url = $url;
    }

    public static function make(string|Closure $url): static
    {
        return new static($url);
    }

    public function method(string|Closure $method): static
    {
        $this->method = is_callable($method) ? $method : strtoupper($method);
        return $this;
    }

    public function icon(string|Closure $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function color(string|Closure $color): static
    {
        $this->color = $color;
        return $this;
    }

    public function confirm(bool|Closure $confirm): static
    {
        $this->confirm = $confirm;
        return $this;
    }

    public function confirmMessage(string $message): static
    {
        $this->confirmMessage = $message;
        return $this;
    }

    public function isLink(object $item): bool        { return in_array($this->getMethod($item), ['GET', null]); }
    public function needsConfirmation(object $item): bool { return is_callable($this->confirm) ? ($this->confirm)($item) : $this->confirm; }
    public function needsDirective(object $item): bool { return !in_array($this->getMethod($item), ['GET', 'POST', null]); }
    public function getUrl(object $item): string { return is_callable($this->url) ? ($this->url)($item) : $this->url; }
    public function getMethod(object $item): ?string        { return is_callable($this->method) ? strtoupper(($this->method)($item)) : $this->method; }
    public function getIcon(object $item): string           { return is_callable($this->icon) ? ($this->icon)($item) : $this->icon; }
    public function getColor(object $item): string          { return is_callable($this->color) ? ($this->color)($item) : $this->color; }
    public function getConfirmMessage(): string          { return $this->confirmMessage; }
}
