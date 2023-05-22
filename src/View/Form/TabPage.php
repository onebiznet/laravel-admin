<?php 

namespace OneBiznet\Admin\View\Form;

use OneBiznet\Admin\View\Traits\HasLabel;

class TabPage extends Container
{
    use HasLabel;

    protected string $view = 'admin::components.form.tab-page';

    protected bool $isActive = false;

    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }

    public function active(bool $active = true): self
    {
        $this->isActive = $active;

        return $this;
    }

    public function getActive(): bool
    {
        return $this->isActive;
    }
}