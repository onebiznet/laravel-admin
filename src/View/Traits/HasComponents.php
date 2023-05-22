<?php 

namespace OneBiznet\Admin\View\Traits;

use Illuminate\Contracts\Support\Arrayable;

trait HasComponents
{
    protected array $components = [];

    public function addComponents(array | Arrayable $components): self 
    {
        foreach($components as $component) {
            $component->parent($this);
        }

        
        $this->components = array_merge($this->components, (array) $components);

        return $this;        
    }

    public function getComponents(): array
    {
        return (array) $this->components;
    }
}