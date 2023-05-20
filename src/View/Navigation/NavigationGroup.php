<?php 

namespace OneBiznet\Admin\View\Navigation;

use Illuminate\Contracts\Support\Arrayable;

class NavigationGroup extends NavigationItem 
{
    protected bool $isCollapsed = true;

    protected ?bool $isCollapsible = null;

    protected array | Arrayable $items = [];

    public function collapsed(bool $condition = true): static
    {
        $this->isCollapsed = $condition;

        $this->collapsible();

        return $this;
    }

    public function collapsible(?bool $condition = true): static
    {
        $this->isCollapsible = $condition;

        return $this;
    }

    public function items(array | Arrayable $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function getItems(): array | Arrayable
    {
        return $this->items;
    }

    public function isCollapsed(): bool
    {
        return (!$this->isChildActive()) && $this->isCollapsed;
    }

    public function isCollapsible(): bool
    {
        return $this->isCollapsible ?? config('admin-panel.layout.sidebar.groups.are_collapsible') ?? true;
    }

    public function isChildActive() : bool 
    {
        foreach($this->items as $item) {
            if ($item->isActive()) return true;
            if (method_exists($item, 'isChildActive') && $item->isChildActive()) return true;
        }

        return false;
    }    
}