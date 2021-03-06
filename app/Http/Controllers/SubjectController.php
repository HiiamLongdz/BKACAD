<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();

        return view('ministry.subjects.list_subject', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ministry.subjects.create_subject');
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
            'subject_id' => ['required', 'unique:subjects,id'],
            'subject_name' => ['required'],
            'total_time' => ['required'],
            'test_type' => ['required']
        ]);

        DB::beginTransaction();

        try {
            $subject = Subject::create([
                'id' => $request->subject_id,
                'subject_name' => $request->subject_name,
                'total_time' => $request->total_time,
                'test_type' => $request->test_type
            ]);

            DB::commit();
            alert()->success('Success!', 'Thêm môn học thành công.');
        } catch (\Throwable $th) {
            DB::rollback();
            alert()->error('Oops..! Đã có lỗi xảy ra vui lòng thử lại');

            return redirect()->back();
        }

        return redirect()->route('list_subject');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
