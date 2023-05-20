<?php 

namespace OneBiznet\Admin\View\Form;

use Butschster\Head\Facades\Meta;

class TelInput extends Field
{
    protected string $view = 'admin::components.form.tel-input';

    public function __construct(string $name)
    {
        parent::__construct($name);

        Meta::includePackages('alpinejs', 'intl-tel-input');
    }
}