<?php 

namespace OneBiznet\Admin\View\Navigation;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;

class NavigationBuilder 
{
    use Conditionable;

    protected array $groups = [];

    protected array $items = [];

    public function group(NavigationGroup | string $group, array $items = [], ?bool $collapsible = null): static 
    {
        if ($group instanceof NavigationGroup) {
            $this->groups[] = $group;

            return $this;
        }

        $this->groups[] = NavigationGroup::make($group)
            ->items($items)
            ->collapsible($collapsible);

        return $this;
    }

    public function item(NavigationItem $item) : static
    {
        $this->items[] = $item;

        return $this;
    }

    public function groups(array $groups) : static 
    {
        $this->groups = array_merge($this->groups, $groups);

        return $this;
    }

    public function items(array $items): static
    {
        $this->items = array_merge($this->items, $items);

        return $this;
    }

    public function getNavigation(): Collection
    {
        $navigation = collect();

        $items = $this->items;

        return collect($items);

        if (count($items)) {
            $navigation->push(
                NavigationGroup::make()
                    ->items($items)
                    ->collapsed(false),
            );
        }
        return $navigation 
            ->merge($this->groups);
    }
}