<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Major;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::all();
        $majors = Major::all();
        return view('ministry.courses.list_course', compact(['courses', 'majors']));
    }

    public function create()
    {
        $majors = Major::all();
        return view('ministry.courses.create_course', compact('majors'));
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'course' => ['required', 'unique:courses,course_name'],
        ]);

        DB::beginTransaction();

        try {
            $course = Course::create([
                'course_name' => $request->course,
            ]);
            DB::commit();

            $new_course = Course::get()->last();

            $new_course->majors()->sync($request->major);

            DB::commit();
            alert()->success('Thành Công!', 'Thêm khóa học mới thành công');
        } catch (\Throwable $th) {
            DB::rollback();
            alert()->error('Oops..!', 'Đã có lỗi xảy ra. Vui lòng thử lại sau');
            return redirect()->back();
        }
        return redirect()->route('list_course');
    }
}
