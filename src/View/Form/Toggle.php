<?php 

namespace OneBiznet\Admin\View\Form;

use OneBiznet\Admin\View\Traits\ToggleHelpers;
use OneBiznet\Admin\View\Traits\HasColor;

class Toggle extends Checkbox
{
    use HasColor;
    
    // protected string $view = 'admin::components.form.toggle';

    protected string $toggleType = 'checkbox';

    public function toggle(string $toggle = 'switch'): self 
    {
        $this->toggleType = $toggle;

        return $this;
    }

    public function getType(): string 
    {
        return $this->toggleType ?? 'checkbox';
    }
}