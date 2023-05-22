<?php 

namespace OneBiznet\Admin\Controllers;

use Spatie\Permission\Models\Permission;

class PermissionController extends BaseController
{
    public function index()
    {
        return view('admin::permissions.index');
    }

    public function edit(Permission $row)
    {
        return view('admin::permissions.form')->with(['permission' => $row]);
    }
}