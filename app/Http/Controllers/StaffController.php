<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::paginate(15);

        return view('staffs.list_staff', compact('users'));
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('staffs.view_staff_detail', compact('user'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('staffs.add_staff', compact('roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'bail|required',
            'dob' => 'bail|required',
            'gender' => 'bail|required',
            'phone' => ['bail', 'required', 'unique:users,phone', 'regex: /^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/'],
            'email' => 'bail|required|unique:users,email|email',
            'password' => 'bail|required|min:8',
            'confirm_password' => 'bail|required|same:password',
        ]);

        DB::beginTransaction();
        try {
            $new_user = User::create([
                'fullname' => $request->fullname,
                'dob' => $request->dob,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            DB::commit();
            alert()->success('Success!', 'Thêm Người Dùng Thành Công');

        } catch (\Throwable $th) {
            DB::rollback();
            alert()->error('Oops..!', 'Có lỗi xảy ra. Vui lòng thử lại');
        }

        $role = Role::findById($request->role);
        $user = User::where('email', $request->email)->first();

        try {
            $user->assignRole($role->name);
            DB::commit();
            alert()->success('Thành Công!', 'Thêm người dùng thành công.');
        } catch (\Throwable $th) {
            DB::rollback();
            alert()->error('Oops..!', 'Đã có lỗi xảy ra. Vui lòng thử lại sau');

            return redirect()->back();
        }

        return redirect()->route('list_staff');
    }

    public function edit($id)
    {
        Alert::info('Coming Soon!', 'Tính Năng Đang Được Cập Nhật');
        return redirect()->back();
    }

    public function update(Request $request)
    {

    }

    public function destroy($id)
    {
        Alert::info('Coming Soon!', 'Tính Năng Đang Được Cập Nhật');
        return redirect()->back();
    }

    public function viewAddLecturer()
    {
        $role = Role::findByName('lecturer');

        return view('ministry.lecturers.add_lecturer', compact('role'));
    }
}
