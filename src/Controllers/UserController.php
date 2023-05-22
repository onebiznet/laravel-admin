<?php 

namespace OneBiznet\Admin\Controllers;

use App\Models\User;
use Spatie\Navigation\Navigation;
use Spatie\Navigation\Section;

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