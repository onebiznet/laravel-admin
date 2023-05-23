<?php

namespace OneBiznet\Admin\View\Form;

use Butschster\Head\Facades\Meta;
use Illuminate\View\ComponentSlot;
use OneBiznet\Admin\View\Traits\HasPlaceholder;

class TomSelect extends Select
{
    use HasPlaceholder;

    protected string $view = 'admin::components.form.tom-select';

    public function __construct(string $name)
    {
        parent::__construct($name);

        Meta::includePackages('alpinejs', 'tom-select-bootstrap');
    }

    public function create(bool | string $create): self
    {
        if ($create) {
            $this->attributes = $this->getAttributes()->merge([
                'data-create' => $create,
            ]);
        } else {
            $this->attributes = $this->getAttributes()->except('data-create');
        }
        return $this;
    }

    public function getSlot()
    {
        $slot = '';
        foreach ($this->getOptions() as $key => $option) {
            $slot .= "<option value='{$key}'>{$option}</option>";
        }

        return new ComponentSlot($slot);
    }
}
