<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'fullname' => 'Lê Văn Long',
                'dob' => '2000-07-22',
                'gender' => '1',
                'phone' => '0979547542',
                'email' => 'levanlong220700@gmail.com',
                'password' => bcrypt('12345678')
            ]
        );

        Role::create(
            [
                'name' => 'admin',
                'description' => 'Quản Trị Viên',
            ],

        );

        Role::create(
            [
                'name' => 'ministry',
                'description' => 'Giáo Vụ',
            ]
        );

        Role::create(
            [
                'name' => 'lecturer',
                'description' => 'Giảng Viên',
            ]
        );

        Permission::create(
            [
                'name' => 'manage role and permission',
                'description' => 'Quản Lí Quyền, Chức Vụ',
            ],
        );

        Permission::create(
            [
                'name' => 'add lecturer',
                'description' => 'Thêm Giảng Viên',
            ],
        );

        Permission::create(
            [
                'name' => 'delete minstry',
                'description' => 'Xóa Giáo Vụ',
            ],
        );
        Permission::create(
            [
                'name' => 'edit ministry',
                'description' => 'Chỉnh Sửa Giáo Vụ',
            ],
        );

        Permission::create(
            [
                'name' => 'delete lecturer',
                'description' => 'Xóa Giảng Viên',
            ],
        );

        Permission::create(
            [
                'name' => 'attendance',
                'description' => 'Điểm Danh',
            ],
        );

        Permission::create(
            [
                'name' => 'attendance over time',
                'description' => 'Điểm Danh Ngoài Giờ',
            ],
        );


        $role = Role::findByName('admin');
        $user = User::first();

        $user->assignRole($role);

    }
}
