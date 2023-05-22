<?php

namespace OneBiznet\Admin\View\Traits;

use Closure;
use Illuminate\View\ComponentAttributeBag;

trait HasPlaceholder
{
    protected string | Closure | null $placeholder = null;

    public function placeholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    protected function hasPlaceholder(): bool
    {
        return $this->placeholder !== null;
    }

    protected function getPlaceholder(): string
    {
        if ($this->placeholder instanceof Closure) {
            $form = $this->hasForm() ? $this->getForm() : null;

            return app()->call($this->placeholder, ['model' => $form ? $form->model : null]);
        }

        return $this->placeholder ?? $this->getLabel();
    } 
}
