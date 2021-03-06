<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Course;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::all();

        return view('ministry.majors.list_major', compact('majors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('ministry.majors.create_major', compact('subjects'));

    }

    // public function viewAddSubjectToMajor()
    // {
    //     $majors = Major::all();
    //     $subjects = Subject::all();
    //     return view('subject.add_subject_to_major', compact(['majors', 'subjects']));
    // }

    // public function addSubjectToMajor(Request $request)
    // {
    //     $major = Major::find($request->course);

    //     DB::beginTransaction();

    //     try {
    //         $major->subjects()->sync($request->subject);

    //         DB::commit();
    //         alert()->success('Success!', 'Thêm môn cho ngành thành công');
    //     } catch (\Throwable $th) {
    //         DB::rollback();
    //         alert()->error('Oops..!', 'Đã có lỗi xảy ra. Vui lòng thử lại sau!');
    //         return redirect()->back();
    //     }

    //     return redirect()->route('xem_mon_cua_nganh');

    // }

    public function showSubjectOfMajor(Request $request)
    {
        if ($request->ajax()) {
            $subjects = Major::find($request->major_id)->subjects;

            return response()->json($subjects);
        }
    }

    public function showCourseMajor(Request $request)
    {
        if ($request->ajax()) {
            $majors = Course::find($request->course_id)->majors;

            return response()->json($majors);
        }
    }

    public function showCourseMajorClass(Request $request)
    {
        if ($request->ajax()) {
            $classes = Classes::all()->where('major_id', $request->major_id)->where('course_id', $request->course_id);
            return response()->json($classes);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'major_id' => ['required', 'unique:majors,id'],
            'major_name' => ['required'],
        ]);

        DB::beginTransaction();

        try {
            $major = Major::create([
                'id' => $request->major_id,
                'major_name' => $request->major_name,
            ]);
            DB::commit();

            $new_major = Major::get()->last();
            $new_major->subjects()->sync($request->subject);

            DB::commit();

            alert()->success('Thành Công!', 'Thêm ngành học mới thành công');
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
            alert()->error('Oop..!', 'Đã có lỗi xảy ra. Vui lòng thử lại sau');
            return redirect()->back();
        }
        return redirect()->route('list_major');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function show(Major $major)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function edit(Major $major)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Major $major)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function destroy(Major $major)
    {
        //
    }
}
