<?php 

namespace OneBiznet\Admin\View\Navigation;

use Illuminate\Contracts\Support\Arrayable;
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

    public function getItems(): array | Arrayable
    {
        return $this->items;
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

    public function getAttributes(): ComponentAttributeBag
    {
        $attributes = parent::getAttributes();

        $attributes = $attributes->merge([
            'class' => ($this->isCollapsed() ? '' : ' menu-open')
        ]);

        return $attributes;
    }    
}