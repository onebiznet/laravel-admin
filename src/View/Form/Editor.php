<?php 

namespace OneBiznet\Admin\View\Form;

use Butschster\Head\Facades\Meta;
use Illuminate\View\ComponentSlot;

class Editor extends Field
{
    public function __construct(string $name)
    {
        parent::__construct($name);

        Meta::includePackages('alpinejs', 'tinymce');
    }
}