<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class StaffController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        return view('staffs.view_staff_detail', compact('user'));
    }
}
