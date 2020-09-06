<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Spatie\Permission\Models\Role;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AssignmentController extends Controller
{

    public function index(Request $request)
    {
        $assignments = Assignment::join('classes', 'classes.id', '=', 'assignments.class_id')
                                ->join('users', 'users.id', '=', 'assignments.lecturer_id')
                                ->join('subjects', 'subjects.id', '=', 'assignments.subject_id')
                                ->select(['class_name', 'subject_name', 'fullname', 'assignments.status'])
                                ->get();

        return view('assignments.assignment_detail', compact('assignments'));
    }

    public function create()
    {
        $courses = Course::all();
        $lecturers = Role::findByName('lecturer')->users;
        return view('assignments.assign', compact(['courses', 'lecturers']));
    }

    public function store(Request $request)
    {
        $classes = $request->class;
        $lecturer = $request->lecturer;
        $subject = $request->subject;
        DB::beginTransaction();

        try {
            foreach ($classes as $class) {
                Assignment::create([
                    'class_id' => $class,
                    'subject_id' => $subject,
                    'lecturer_id' => $lecturer,
                ]);
            }
            DB::commit();
            alert()->success('Thành Công!', 'Phân Công Thành Công');
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollback();
            alert()->error('Oops..!', 'Có lỗi xảy ra. Vui lòng thử lại');
            return redirect()->back();
        }
        return redirect()->route('assignment_detail');
    }
}
