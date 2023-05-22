<?php 

namespace OneBiznet\Admin\View\Form;

use Illuminate\View\ComponentSlot;
use OneBiznet\Admin\View\Traits\HasComponents;

abstract class Container extends Component
{
    use HasComponents;

    public function getSlot()
    {
        $slot = '';

        foreach($this->components as $component) {
            $slot .= $component->render();
        }

        return new ComponentSlot($slot);
    }
}