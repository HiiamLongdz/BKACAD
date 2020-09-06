<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Major;
use App\Models\Classes;
use App\Imports\StudentImport;
use Yajra\DataTables\Facades\DataTables;
class StudentController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::all();
        return view('students.list_student', compact('courses'));
    }

    public function getIndex()
    {
        return view('students.list_student');
    }

    public function getListStudent()
    {
        if (request()->ajax()) {
            return $this->datatables();
        }
    }

    public function datatables()
    {
        $student = Student::where('classes_id', request()->classes_id)->get(['id', 'fullname', 'email', 'created_at', 'updated_at']);

        return Datatables::of($student)->make(true);
    }

    public function getListStudentAttendance(Request $request)
    {
        if($request->ajax()){
            $class = $request->class_id;

            $students = Student::whereIn('classes_id', $class)->get();

            return response()->json($students);
        }
    }

    public function import()
    {
        $courses = Course::all();
        return view('students.import_student', compact('courses'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $studentPerClass = $request->student1class;
        $course = $request->course;
        $major = $request->major;

        $major_name = Major::find($major);
        $course_name = Course::find($course);

        try {
            Excel::import(new StudentImport, $request->file('file'));

            $studentNoClass = Student::where('classes_id', null)->get();

            $totalClass = ceil(count($studentNoClass) / $studentPerClass);
            $limit = $studentPerClass;

            for ($i = 1; $i <= $totalClass; $i++) {
                Classes::create([
                    'class_name' => $major_name->id . '0' . $i . $course_name->course_name,
                    'course_id' => $course_name->id,
                    'major_id' => $major_name->id,
                ]);

                $classes = Classes::get()->last();

                $studentNoClass = Student::where('classes_id', null)->limit($limit)->get();
                foreach ($studentNoClass as $key => $value) {
                    $value->update(['classes_id' => $classes->id]);
                }
            }

            DB::commit();
            alert()->success('Thành Công!', 'Nhập sinh viên và chia lớp thành công');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
            alert()->error('Oops..!', 'Đã có lỗi xảy ra, vui lòng thử lại sau.');

            return redirect()->back();
        }

        return redirect()->route('list_student');
    }
}
