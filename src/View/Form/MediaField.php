<?php

namespace OneBiznet\Admin\View\Form;

use Butschster\Head\Facades\Meta;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\View\ComponentAttributeBag;
use OneBiznet\Admin\View\Traits\HasRelationship;

class MediaField extends Field
{
    use HasRelationship;

    protected string $view = 'admin::components.form.media-field';

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

    public function render()
    {
        if ($this->getAttributes()->has('multiple')) {
            Meta::includePackages('alpinejs', 'draganddrop');
        }

        return parent::render();
    }

    public function getImages(): array | Arrayable
    {
        if ($this->hasForm() && $form = $this->getForm()) {
            if ($this->hasRelation()) {
                $relation = $this->getRelation();
                return method_exists($form->model, $relation) ? $form->model->{$relation}: null;
            }

            return $form->{$this->getModel()};
        }

        return [];
    }
}
