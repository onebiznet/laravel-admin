<?php 

namespace OneBiznet\Admin\Controllers;

use Spatie\Permission\Models\Role;

class RoleController extends BaseController
{
    public function index()
    {
        return view('admin::roles.index');
    }

    public function edit(Role $row)
    {
        return view('admin::roles.form')->with(['role' => $row]);
    }
}