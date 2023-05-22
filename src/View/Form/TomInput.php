<?php 

namespace OneBiznet\Admin\View\Form;

use Butschster\Head\Facades\Meta;
use OneBiznet\Admin\View\Traits\HasPlaceholder;

class TomInput extends TextInput
{
    protected string $view = 'admin::components.form.tom-input';

    public function __construct(string $name)
    {
        parent::__construct($name);

        Meta::includePackages('alpinejs', 'tom-select-bootstrap');
    }
}