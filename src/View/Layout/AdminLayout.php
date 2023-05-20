<?php 

namespace OneBiznet\Admin\View\Layout;

use Butschster\Head\Facades\Meta;
use Illuminate\View\Component;

class AdminLayout extends Component
{
    public function __construct()
    {
        Meta::includePackages('adminlte');    
    }

    public function render()
    {
        return view('admin::layouts.app');
    }
}