<?php

namespace OneBiznet\Admin\View\Traits;

use Closure;
use Illuminate\Support\Str;
use Illuminate\View\ComponentAttributeBag;

trait Togglable
{
    protected bool | Closure $checked = false;

    public function checked(bool | Closure $checked = true): self
    {
        $this->checked = $checked;

        return $this;
    }

    public function isChecked(): bool
    {
        if ($this->hasCheckedCallback()) {
            return app()->call($this->checked, ['model' => ($form = $this->getForm()) ? $form->model : null]);
        }

        return (bool) $this->checked;
    }

    public function hasCheckedCallback(): bool
    {
        return $this->checked instanceof Closure;
    }

    public function getAttributes(): ComponentAttributeBag
    {
        $attributes = parent::getAttributes();

        return $this->isChecked() ? $this->attributes->merge(['checked' => true]) : $attributes->except('checked');
    }
}
