<?php 

namespace OneBiznet\Admin\View\DataTable\Traits;

trait ButtonColumnHelpers 
{
    public function getActionCallback()
    {
        return $this->actionCallback;
    }

    public function hasActionCallback()
    {
        return $this->actionCallback !== null;
    }

    public function getIconCallback()
    {
        return $this->iconCallback ?? fn() => null;
    }

    public function getIcon()
    {
        return empty($this->icon) ? '' : '<i class="'.$this->icon.'"></i>';
    }

    public function getColor()
    {
        return $this->color ?? 'primary';
    }

    public function getView(): string
    {
        return $this->view;
    }

}