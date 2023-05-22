<?php 

namespace OneBiznet\Admin\View\Traits;

trait HasRules
{
    protected ?string $rules = null;

    public function rules(string $rules): self 
    {
        $this->rules = $rules;

        return $this;
    }

    public function hasRules(): bool 
    {
        return $this->rules !== null;
    }

    public function getRules(): ?string
    {
        return $this->rules ?? '';
    }
}