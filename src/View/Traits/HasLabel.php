<?php

namespace OneBiznet\Admin\View\Traits;

use Closure;
use Illuminate\Support\Str;

trait HasLabel
{
    protected string | Closure | null $label = null;

    protected bool $withoutLabel = false;

    public function label(string | Closure $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function withoutLabel(bool $withoutLabel): self
    {
        $this->withoutLabel = $withoutLabel;

        return $this;
    }

    public function getLabel(): ?string
    {
        if ($this->withoutLabel) {
            return null;
        }

        if ($this->label instanceof Closure) {
            return app()->call($this->label, ['model' => $this->getModel() ?? null]);
        }

        return $this->label ?? Str::title(str_replace(['-','_'], ' ', $this->name));
    }
}
