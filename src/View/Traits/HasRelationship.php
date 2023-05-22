<?php 

namespace OneBiznet\Admin\View\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasRelationship
{
    protected ?string $relation = null;

    protected string $relatedLabel;

    public function relationship(string $relation, ?string $label = null): self 
    {
        if (strpos($relation, '.') !== false) {
            list($this->relation, $this->relatedLabel) = explode('.', $relation, 2);
        } else {
            $this->relation = $relation;
            $this->relatedLabel = $label;
        }

        return $this;
    }

    public function hasRelation(): bool 
    {
        return $this->relation !== null;
    }

    public function getRelation(): ?string 
    {
        return $this->relation;
    }

    protected function getRelationship(): ?Relation
    {
        if ($this->hasRelation() && $this->hasForm()) {
            $form = $this->getForm();
            $model = $form->model;

            return $model instanceof Model && method_exists($model, $this->relation) ? $model->{$this->relation}() : null;
        }

        return null;
    }
}