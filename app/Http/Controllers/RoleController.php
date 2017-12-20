<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.roles.index')->withRoles($roles)->withPermissions($permissions);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'role_name' => 'required',
            'permissions' => 'array|min:1'
        ]);
        $role = Role::create(['name' => $request->role_name]);
        foreach($request->permissions as $permission) {
            $role->givePermissionTo($permission);
        }
        return redirect()->route('role.index');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $role = Role::find($id);      
        $permissions = Permission::all()->pluck('name');
        return view('admin.roles.edit')->withRole($role)->withPermissions($permissions);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'role_name' => 'required',
            'permissions' => 'array|min:1'
        ]);
        $role = Role::find($id);
        $role->update(['name' => $request->role_name]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('role.index');
    }

    public function destroy($id)
    {

    }
}
