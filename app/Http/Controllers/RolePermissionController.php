<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles_permissions.view_role_permission', compact('roles'));
    }

    public function edit()
    {
        $roles = Role::all();

        $permissions = Permission::all();
        return view('roles_permissions.view_modify', compact(['roles', 'permissions']));
    }
}
