<?php 

namespace OneBiznet\Admin\View\Form\Traits;

use BaconQrCode\Renderer\Path\Close;
use Closure;

trait HasColor
{
    protected string | Closure $color = 'primary';

    public function color(string | Closure $color):self 
    {
        $this->color = $color;

        return $this;
    }

    public function getColor(): string 
    {
        if ($this->color instanceof Closure) {
            return app()->call($this->color, ['model' => $this->getForm() ?? null]);
        }

        return $this->color;
    }
}