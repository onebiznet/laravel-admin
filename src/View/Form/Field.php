<?php 

namespace OneBiznet\Admin\View\Form;

use Illuminate\View\ComponentAttributeBag;
use OneBiznet\Admin\View\Traits\HasLabel;
use OneBiznet\Admin\View\Traits\HasModel;
use OneBiznet\Admin\View\Traits\HasRules;
use OneBiznet\Admin\View\Traits\Wirable;

class Field extends Component
{
    use HasRules, 
        HasLabel,
        Wirable,
        HasModel;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getAttributes(): ComponentAttributeBag
    {
        $attributes = parent::getAttributes();

        $attributes = $this->hasForm()
            ? $attributes->merge(['wire:model.lazy' => $this->getName()])
            : $attributes;

        return $attributes;
    }
}