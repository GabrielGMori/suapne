<?php

namespace App\View\Components;
use Closure;
use function in_array;

class ListViewAction
{
    private string|Closure $url;
    private string|Closure $defaultUrl;
    private string|Closure|null $method = null;
    private string|Closure $icon    = 'open_in_new';
    private string|Closure $color   = 'transparent';
    private bool|Closure $confirm   = false;
    private bool|Closure $filledConfirm = false;
    private string|Closure $confirmMessage = '';

    private function __construct(string|Closure $url)
    {
        $this->url = $url;
        $this->defaultUrl = $url;
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

    public function confirm(bool|Closure $confirm = true): static
    {
        $this->confirm = $confirm;
        return $this;
    }

    public function filledConfirm(bool|Closure $filled = true): static
    {
        $this->filledConfirm = $filled;
        return $this;
    }

    public function confirmMessage(string|Closure $message): static
    {
        $this->confirmMessage = $message;
        return $this;
    }

    public function restoreOnTrashed(string|Closure $restoreUrl, ?string $confirmMessage = null): static
    {
        $this->url = function (object $item) use ($restoreUrl) {
            if (!method_exists($item, 'trashed') || !$item->trashed()) {
                return is_callable($this->defaultUrl) ? ($this->defaultUrl)($item) : $this->defaultUrl;
            }

            return is_callable($restoreUrl) ? $restoreUrl($item) : $restoreUrl;
        };

        $this->method = fn(object $item) => $item->trashed() ? 'POST' : 'GET';
        $this->icon = fn(object $item) => $item->trashed() ? 'restore' : 'open_in_new';
        $this->color = fn(object $item) => $item->trashed() ? 'primary' : 'transparent';
        $this->confirm = fn(object $item) => $item->trashed();

        if ($confirmMessage !== null) {
            $this->confirmMessage = $confirmMessage;
        }

        return $this;
    }

    public function isLink(object $item): bool        { return in_array($this->getMethod($item), ['GET', null]); }
    public function needsConfirmation(object $item): bool { return is_callable($this->confirm) ? ($this->confirm)($item) : $this->confirm; }
    public function needsDirective(object $item): bool { return !in_array($this->getMethod($item), ['GET', 'POST', null]); }
    public function getUrl(object $item): string { return is_callable($this->url) ? ($this->url)($item) : $this->url; }
    public function getMethod(object $item): ?string        { return is_callable($this->method) ? strtoupper(($this->method)($item)) : $this->method; }
    public function getIcon(object $item): string           { return is_callable($this->icon) ? ($this->icon)($item) : $this->icon; }
    public function getColor(object $item): string          { return is_callable($this->color) ? ($this->color)($item) : $this->color; }
    public function isFilledConfirm($item): string          { return is_callable($this->filledConfirm) ? ($this->filledConfirm)($item) : $this->filledConfirm; }
    public function getConfirmMessage($item): string          { return is_callable($this->confirmMessage) ? ($this->confirmMessage)($item) : $this->confirmMessage; }
}
