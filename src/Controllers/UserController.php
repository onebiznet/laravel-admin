<?php 

namespace OneBiznet\Admin\Controllers;

use App\Models\User;

class UserController extends BaseController
{
    public function index()
    {
        return view('admin::users.index');
    }

    public function edit(User $row)
    {
        return view('admin::users.form', ['user' => $row]);
    }
}