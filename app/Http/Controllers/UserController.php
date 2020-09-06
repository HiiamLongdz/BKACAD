<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        alert()->warning('Coming Soon!', 'Tính năng đang được cập nhật!');
        return redirect()->route('dashboard');
    }
}
