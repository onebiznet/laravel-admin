<?php

namespace OneBiznet\Admin\View\Form\Traits;

use Closure;

trait Collapsible
{
    protected bool $isCollapsed = false;

    protected ?Closure $collapseIf = null;

    public function collapseIf(?Closure $callback): self
    {
        $this->collapseIf = $callback;

        return $this;
    }

    public function collapsed(bool $isCollapsed): self
    {
        $this->isCollapsed = $isCollapsed;

        return $this;
    }

    public function getCollapseIf(): ?Closure
    {
        return $this->collapseIf;
    }

    public function isCollapsed(): bool
    {
        if ($this->getCollapseIf() !== null) {
            return app()->call($this->collapseIf, ['model' => ($this->getForm() ? $this->getForm()->model : null)]);
        }

        return $this->isCollapsed ?? false;
    }
}
