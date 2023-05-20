<?php 

namespace OneBiznet\Admin\View\Form;

use OneBiznet\Admin\View\Form\Traits\HasOptions;

class Radio extends Checkbox
{
    use HasOptions;

    protected string $view = 'admin::components.form.radio';

    protected string $type = 'radio';
}