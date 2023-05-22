<?php 

namespace OneBiznet\Admin\View\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Wirable 
{
    public function hasForm(): bool
    {
        return $this->getForm() !== null;
    }

    public function getName(): string
    {
        if ($this->hasForm()) {
            if (method_exists($this, 'hasRelation') && $this->hasRelation()) {
                $relationship = $this->getRelationship();
                if ($relationship instanceof MorphToMany || $relationship instanceof BelongsToMany) {
                    return 'relationships.'.$relationship->getRelationName().'.'.parent::getName();
                }
            }
            return $this->model.'.'.parent::getName();
        }

        return parent::getName();
    }
}