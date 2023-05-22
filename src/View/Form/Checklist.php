<?php 

namespace OneBiznet\Admin\View\Form;

use OneBiznet\Admin\View\Traits\HasRelationship;

class Checklist extends Radio 
{
    use HasRelationship;
    
    protected string $view = 'admin::components.form.checklist';

    protected string $type = 'checkbox';
}