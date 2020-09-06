<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function create()
    {
        $lecturer = auth()->user()->id;
        $date_time = Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString();

        $get_time = explode(" ", $date_time);
        // dd($get_time);
        $last_att = Attendance::where('lecturer_id', $lecturer)->get()->last();
        $subjects = Assignment::join('subjects', 'subjects.id', '=', 'assignments.subject_id')
        ->where('lecturer_id', $lecturer)
        ->groupBy('subjects.id', 'subject_name')
        ->get(['subjects.id', 'subject_name']);

        if (empty($last_att) || ($get_time[0] >= $last_att->date && $get_time[1] > $last_att->time_end)) {

            return view('attendances.attend', compact('subjects'));
        } else {
            $att_id = $last_att->id;
            $classes = DB::table('attendance_details')->where('attendance_id', $att_id)->get('class_id')->unique('class_id');
            $subject = Subject::find($last_att->subject_id);

            // return view('attendances.update_attend', );
        }
    }

    public function store(Request $request)
    {
        // 1 -> s: 8.00 e: 10.00
        // 2 -> s: 10:00 e: 12.00
        // 3 -> s: 8.00 e: 12.00
        // 4 -> s: 13.30 e: 17.30
        // 5 -> s: 15:30 e: 17.30
        // 6 -> s: 13.30 e: 17.30
        $lecturer = auth()->user()->id;
        $subject = $request->subject;

        $date = Carbon::now()->toDateString();
        $classes = $request->class;
        $time = $request->time;
        switch ($time) {
            case '1':
                $time_start = '08:00:00';
                $time_end = '10:00:00';
                break;
            case '2':
                $time_start = '10:00:00';
                $time_end = '12:00:00';
                break;
            case '3':
                $time_start = '08:00:00';
                $time_end = '12:00:00';
                break;
            case '4':
                $time_start = '13:30:00';
                $time_end = '15:30:00';
                break;
            case '5':
                $time_start = '15:30:00';
                $time_end = '17:30:00';
                break;
            case '6':
                $time_start = '13:30:00';
                $time_end = '17:30:00';
                break;
            default:

                break;
        }

        Attendance::create([
            'lecturer_id' => $lecturer,
            'subject_id' => $subject,
            'date' => $date,
            'time_start' => $time_start,
            'time_end' => $time_end,
        ]);

        $last_att = Attendance::where('lecturer_id', $lecturer)->get()->last();
        $arr = array();

        $students = Student::whereIn('classes_id', $classes)->get();

        foreach ($students as $key) {
            $id = $key->id;

            $status = $request->$id;
            DB::table('attendance_details')->insert([
                'attendance_id' => $last_att->id,
                'student_id' => $id,
                'status' => $status,
                'class_id' => $key->classes_id,
            ]);
        }

    }
}
