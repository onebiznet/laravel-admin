<?php 

namespace OneBiznet\Admin\View\Form;

use Butschster\Head\Facades\Meta;

class DateTimeInput extends Field
{
    protected string $view = 'admin::components.form.datetime-input';

    public function __construct(string $name)
    {
        parent::__construct($name);

        Meta::includePackages('alpinejs', 'flatpickr');
    }

}