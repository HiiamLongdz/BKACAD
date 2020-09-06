<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Attendance;
use App\Models\Assignment;
use Illuminate\Support\Facades\DB;
use App\Models\Classes;
use App\Models\Subject;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lecturer = auth()->user()->id;
        $date_time = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();

        $get_time = explode(" ", $date_time);
        // dd($get_time);
        $last_att = Attendance::where('lecturer_id', $lecturer)->get()->last();
        $subjects = Subject::find($last_att->subject_id)->first();
            $att_id = $last_att->id;

            $class = DB::table('attendance_details')->where('attendance_id', $att_id)->get('class_id')->unique();
            $att_details = DB::table('attendance_details')
            ->join('students', 'students.id', '=', 'attendance_details.student_id')
            ->join('attendances', 'attendances.id', '=', 'attendance_details.attendance_id')
            ->where('attendance_id', $att_id)
            ->where('subject_id', $subjects->id)
            ->select(['students.id', 'fullname', 'attendance_details.status'])
            ->selectRaw('count(attendances.id) as total')
            ->selectRaw('sum(if( attendance_details.status = 0, 0, if( attendance_details.status = 1, 1/3, if( attendance_details.status = 2, 1/3, 1)))) as total_abs')
            ->groupBy(['students.id', 'fullname', 'attendance_details.status'])
            ->orderBy('fullname')
            ->get();

            $arr_class = array();

            foreach($class as $key => $value){
                array_push($arr_class, $value->class_id);
            }



            $classes = Classes::whereIn('id', $arr_class)->get();

            return view('attendances.update_attendance', compact(['last_att', 'classes', 'subjects', 'att_details']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function show(Test $test)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function edit(Test $test)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Test $test)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Test  $test
     * @return \Illuminate\Http\Response
     */
    public function destroy(Test $test)
    {
        //
    }
}
