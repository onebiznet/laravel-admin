<?php

namespace OneBiznet\Admin\View\Form;

use Illuminate\View\ComponentAttributeBag;
use OneBiznet\Admin\View\Form\Traits\HasPlaceholder;

class TextInput extends Field
{
    use HasPlaceholder;

    protected string $view = 'admin::components.form.text-input';

    protected string $type = 'text';

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAttributes(): ComponentAttributeBag
    {
        $attributes = parent::getAttributes()->merge([
            'type' => $this->type
        ]);

        return $this->hasPlaceholder()
            ? $attributes->merge(['placeholder' => $this->getPlaceholder()])
            : $attributes->except('placeholder');
    }    
}
