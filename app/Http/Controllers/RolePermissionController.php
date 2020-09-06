<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles_permissions.view_role_permission', compact('roles'));
    }


    public function edit($id)
    {
        $role = Role::findById($id);

        $permissions = Permission::all();

        return view('roles_permissions.update_permission_to_role', compact(['role', 'permissions']));

    }


    public function update(Request $request)
    {
        $role = $request->role;
        $permissions = $request->permission;

        $role = Role::findById($role);
        DB::beginTransaction();

        try {
            foreach ($permissions as $permission) {
                $permission = Permission::findById($permission);

                $role->syncPermissions($permissions);

                DB::commit();
                alert()->success('Thành Công!', 'Cập nhật quyền cho chức vụ thành công!');
            }
        } catch (\Throwable $th) {
            DB::rollback();

            alert()->error('Oops..!', 'Đã có lỗi xảy ra, vui lòng thử lại.');
            return redirect()->back();
        }

        return redirect()->route('view_role_permission');
    }

    // public function update(Request $request)
    // {
    //     $roles = $request->role;
    //     $permissions = $request->permission;

    //     $roles = Role::findById($roles);

    //     DB::beginTransaction();

    //     try {
    //         foreach($permissions as $permission) {
    //             $permission = Permission::findById($permission);
    //             $roles->givePermissionTo($permission);
    //         }

    //         DB::commit();
    //         alert()->success('Thành Công!', 'Đồng bộ quyền thành công cho chức vụ');
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         DB::rollback();
    //         alert()->error('Oops..!', 'Đã có lỗi xảy ra, vui lòng thử lại!');
    //         return redirect()->back();
    //     }

    //     return redirect()->route('view_role_permission');
    // }
}
