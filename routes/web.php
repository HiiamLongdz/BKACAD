<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::group(['middleware' => ['role:admin']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('admin', function () {
            return redirect()->route('');
        });

        Route::get('view_role_permission', 'RolePermissionController@index')->name('view_role_permission');
        Route::get('view_staff_detail/{id}', 'StaffController@show')->name('view_staff_detail');
        Route::get('edit_staff_detail/{id}', 'StaffController@update')->name('edit_staff_detail');

        Route::get('edit_role_permission', 'RolePermissionController@edit')->name('edit_role_permission');
        Route::post('update_role_permission', 'RolePermissionController@update')->name('update_role_permission');
    });
});
