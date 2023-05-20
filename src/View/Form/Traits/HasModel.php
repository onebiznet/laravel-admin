<?php 

namespace OneBiznet\Admin\View\Form\Traits;

trait HasModel 
{
    protected string $model = 'model';

    public function model(string $model): self 
    {
        $this->model = $model;

        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }
}