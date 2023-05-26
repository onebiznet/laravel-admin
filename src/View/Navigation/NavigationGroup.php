<?php 

namespace OneBiznet\Admin\View\Navigation;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\View\ComponentAttributeBag;
use OneBiznet\Admin\View\Traits\Collapsible;

class NavigationGroup extends NavigationItem 
{
    use Collapsible;
    
    protected array | Arrayable $items = [];

    public function __construct(?string $name = null)
    {
        parent::__construct($name);

        $this->isCollapsed = true;
    }

    public function collapsed(bool $condition = true): static
    {
        $this->isCollapsed = $condition;

        return $this;
    }

    public function items(array | Arrayable $items): static
    {
        $this->items = $items;

        return $this;
    }

    public function add(NavigationItem ...$items): static 
    {
        return $this->items(array_merge($this->items, $items));
    }

    public function getItems(): Collection
    {
        return collect($this->items);
    }

    public function isCollapsed(): bool
    {
        return (!$this->isChildActive()) && $this->isCollapsed;
    }

    public function isChildActive() : bool 
    {
        foreach($this->items as $item) {
            if ($item->isActive()) return true;
            if (method_exists($item, 'isChildActive') && $item->isChildActive()) return true;
        }

        return false;
    }

    public function getActive(): bool 
    {
        return $this->isActive() || $this->isChildActive();
    }

    public function getAttributes(): ComponentAttributeBag
    {
        $attributes = parent::getAttributes();

        $attributes = $attributes->merge([
            'class' => ($this->isCollapsed() ? '' : ' menu-open')
        ]);

        return $attributes;
    }    
}