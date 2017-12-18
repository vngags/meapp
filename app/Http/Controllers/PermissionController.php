<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index')->withPermissions($permissions);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'permission_name' => 'required'
        ]);
        Permission::create(['name' => $request->permission_name]);
        return redirect()->route('permission.index');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
