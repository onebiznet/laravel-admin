<?php 

namespace OneBiznet\Admin\View\Form\Traits;

use Illuminate\Support\Str;

trait HasCaption 
{
    protected ?string $caption = null;

    public function caption(string $caption): self
    {
        $this->caption = $caption;

        return $this;
    }

    public function getCaption(): string
    {
        return $this->caption ?? Str::replace(['.', '_'], ' ', $this->name);
    }


}