<?php

namespace OneBiznet\Admin\View\Form;

use Butschster\Head\Facades\Meta;
use Illuminate\View\ComponentAttributeBag;
use OneBiznet\Admin\View\Form\Traits\HasLabel;
use OneBiznet\Admin\View\Form\Traits\HasColor;

class IconPicker extends Field
{
    use HasColor,
        HasLabel;

    protected string $view = 'admin::components.form.icon-picker';

    protected string $type = 'button';

    public function __construct(string $name)
    {
        $this->name = $name;

        Meta::includePackages('alpinejs', 'iconpicker');
    }

    public function getType(): string 
    {
        return 'button';
    }

    public function getAttributes(): ComponentAttributeBag
    {
        $attributes = parent::getAttributes();

        return $attributes->merge([
            'color' => $this->getColor(),
        ])->except('class');
    }
}
