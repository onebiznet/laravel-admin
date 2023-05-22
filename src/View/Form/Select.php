<?php

namespace OneBiznet\Admin\View\Form;

use OneBiznet\Admin\View\Traits\HasOptions;
use OneBiznet\Admin\View\Traits\HasRelationship;

class Select extends Field
{
    use HasRelationship,
        HasOptions;

    public function multiple(bool $multiple = true): self
    {
        if ($multiple) {
            $this->attributes = $this->getAttributes()->merge([
                'multiple' => 'multiple'
            ]);
        } else {
            $this->attributes = $this->getAttributes()->except('multiple');
        }

        return $this;
    }
}
