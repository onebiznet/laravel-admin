<?php 

namespace OneBiznet\Admin\View\Form;

use OneBiznet\Admin\View\Traits\HasCaption;
use OneBiznet\Admin\View\Traits\HasColor;
use OneBiznet\Admin\View\Traits\Togglable;

class Checkbox extends Field
{
    use Togglable,
        HasCaption,
        HasColor;   

    protected string $view = 'admin::components.form.checkbox';

    protected string $type = 'checkbox';

    public function type(string $toggle): self 
    {
        $this->type = $toggle;

        return $this;
    }

    public function toggle(): self 
    {
        return $this->type('toggle');        
    }

    public function switch(): self 
    {
        return $this->type('switch');        
    }

    public function checkbox(): self 
    {
        return $this->type('checkbox');        
    }    

    public function radio(): self 
    {
        return $this->type('radio');        
    }

    public function getType(): string 
    {
        return $this->type ?? 'checkbox';
    }    
}