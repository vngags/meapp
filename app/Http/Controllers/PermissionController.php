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
        $permissions = Permission::find($id);
        return view('admin.permissions.edit')->withPermission($permissions);
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy(Request $request, $id)
    {
        $permissions = Permission::find($id);
        $permissions->delete();
        return redirect()->route('permission.index');
    }
}
