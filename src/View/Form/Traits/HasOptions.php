<?php

namespace OneBiznet\Admin\View\Form\Traits;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

trait HasOptions
{
    protected array | Closure $options = [];

    public function options(array | Arrayable | Closure $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions(): Collection
    {
        if ($this->options instanceof Closure) {
            $form = $this->getForm();
            return app()->call($this->options, ['model' => $form ? $form->model : null]);
        }

        if (!empty($this->options)) return collect($this->options);

        if ($this->hasRelation() && $this->hasForm()) {
            $relationship = $this->getRelationship();
            $related = $relationship->getRelated();
            $label = $this->relatedLabel ?? $related->getKeyName();

            return $related->all()->mapWithKeys(function ($model) use ($relationship, $label) {
                return [$model->{$relationship->getRelatedKeyName()} => $model->{$label}];
            });
        }

        return collect();
    }
}
