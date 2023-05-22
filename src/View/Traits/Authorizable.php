<?php

namespace OneBzinet\Admin\View\Traits;

use Closure;

trait Authorizable
{
    protected array | Closure | null $allowed = null;

    protected array | Closure | null $forbidden = null;

    public function allowed(string ...$permissions): self
    {
        $this->allowed = $permissions;

        return $this;
    }

    public function forbidden(string ...$permissions): self
    {
        $this->forbidden = $permissions;

        return $this;
    }

    public function allowIf(Closure $closure): self
    {
        $this->allowed = $closure;

        return $this;
    }

    public function forbidIf(Closure $closure): self
    {
        $this->forbidden = $closure;

        return $this;
    }

    public function isAllowed() : bool 
    {
        if ($this->allowed instanceof Closure) {
            
        }
        return true;
    }
}
