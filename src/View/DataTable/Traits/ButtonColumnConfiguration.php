<?php 

namespace OneBiznet\Admin\View\DataTable\Traits;

trait ButtonColumnConfiguration
{
    public function title(callable $callback): self 
    {
        $this->titleCallback = $callback;

        return $this;
    }

    public function action(callable $callback): self 
    {
        $this->actionCallback = $callback;

        return $this;
    }

    public function attributes(callable $callback): self
    {
        $this->attributesCallback = $callback;
        
        return $this;
    }    

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }
}