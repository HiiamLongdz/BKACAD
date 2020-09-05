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
            return redirect()->route('view_role_permission');
        });

        Route::get('view_role_permission', 'RolePermissionController@index')->name('view_role_permission');
        Route::get('view_staff_detail/{id}', 'StaffController@show')->name('view_staff_detail');
        Route::get('edit_staff_detail/{id}', 'StaffController@edit')->name('edit_staff_detail');
        Route::get('update_staff_detail/{id}', 'StaffController@update')->name('update_staff_detail');

        Route::get('edit_permission_to_role/{id}', 'RolePermissionController@edit')->name('edit_permission_to_role');
        Route::post('update_permission_to_role', 'RolePermissionController@update')->name('update_permission_to_role');

        Route::get('list_staff', 'StaffController@index')->name('list_staff');
        Route::get('delete_staff/{id}', 'StaffController@destroy')->name('delete_staff');
        Route::get('add_staff', 'StaffController@create')->name('add_staff');
        Route::post('process_add_staff', 'StaffController@store')->name('process_add_staff');
    });
});

Route::group(['middleware' => ['role:ministry|admin']], function () {
    Route::group(['prefix' => 'ministry'], function () {
        Route::get('ministry', function () {
            return redirect()->route('');
        });
        Route::group(['prefix' => 'lecturer'], function () {
            Route::get('add_lecturer', 'StaffController@viewAddLecturer')->name('add_lecturer');
            Route::post('process_add_lecturer', 'StaffController@store')->name('process_add_lecturer');
        });

        Route::group(['prefix' => 'course'], function () {
            Route::get('create_subject', 'SubjectController@create')->name('create_subject');
            Route::post('process_create_subject', 'SubjectController@store')->name('process_create_subject');
            Route::get('list_subject', 'SubjectController@index')->name('list_subject');

            Route::get('create_major', 'MajorController@create')->name('create_major');
            Route::post('process_create_major', 'MajorController@store')->name('process_create_major');
            Route::get('list_major', 'MajorController@index')->name('list_major');

            Route::get('create_course', 'CourseController@create')->name('create_course');
            Route::post('process_create_course', 'CourseController@store')->name('process_create_course');
            Route::get('list_course', 'CourseController@index')->name('list_course');

        });

        Route::group(['prefix' => 'student'], function () {
            Route::get('import_student', 'StudentController@import')->name('import_student');
            Route::post('process_import_student', 'StudentController@store')->name('process_import_student');
            Route::get('list_student', 'StudentController@index')->name('list_student');

        });
    });
});

Route::post('show_course_major', 'MajorController@showCourseMajor')->name('show_course_major');
Route::post('show_course_major_class', 'MajorController@showCourseMajorClass')->name('show_course_major_class');
Route::get('get_list_student', 'StudentController@getListStudent')->name('get_list_student');
