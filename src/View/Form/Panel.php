<?php 

namespace OneBiznet\Admin\View\Form;

use Illuminate\View\ComponentAttributeBag;
use OneBiznet\Admin\View\Form\Traits\Collapsible;

class Panel extends Container
{
    use Collapsible;
    
    public function __construct(?string $name)
    {
        $this->name = $name;
    }

    public function getAttributes(): ComponentAttributeBag
    {
        $attributes = parent::getAttributes();

        $attributes = $attributes->merge([
            'class' => 'collapse fade'.($this->isCollapsed() ? '' : ' show')
        ]);

        return $attributes;
    }

}