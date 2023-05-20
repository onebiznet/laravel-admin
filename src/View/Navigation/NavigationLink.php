<?php

namespace OneBiznet\Admin\View\Navigation;

use Closure;

class NavigationLink extends NavigationItem
{
    protected bool $shouldOpenUrlInNewTab = false;

    protected string | Closure | null $url = null;

    public function openUrlInNewTab(bool $condition = true): static
    {
        $this->shouldOpenUrlInNewTab = $condition;

        return $this;
    }

    public function url(string | Closure | null $url, bool $shouldOpenInNewTab = false): static
    {
        $this->shouldOpenUrlInNewTab = $shouldOpenInNewTab;
        $this->url = $url;

        return $this;
    }

    public function route(string $name): static
    {
        $route = route($name);
        $this->url($route);
        $this->isActiveWhen(function() use ($name) {
            return request()->routeIs($name);
        });
        return $this;
    }

    public function getUrl(): ?string
    {
        return value($this->url);
    }

    public function isActive(): bool
    {
        $callback = $this->isActiveWhen;

        if ($callback === null) {
            return false;
        }

        return app()->call($callback);
    }

    public function shouldOpenUrlInNewTab(): bool
    {
        return $this->shouldOpenUrlInNewTab;
    }
}
