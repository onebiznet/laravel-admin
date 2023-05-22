<?php 

namespace OneBiznet\Admin\View\Form;

use OneBiznet\Admin\View\Traits\HasOptions;

class Radio extends Checkbox
{
    use HasOptions;

    protected string $view = 'admin::components.form.radio';

    protected string $type = 'radio';
}