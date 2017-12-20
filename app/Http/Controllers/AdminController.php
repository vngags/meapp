<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use App\Product;

class AdminController extends Controller
{
    public function dashbroad()
    {
        $data = [
            'users' => User::all(),
            'permissions' => Permission::all(),
            'roles' => Role::all(),
            'products' => Product::all()
        ];
        return view('admin.dashbroad', ['data' => $data]);
    }
}
