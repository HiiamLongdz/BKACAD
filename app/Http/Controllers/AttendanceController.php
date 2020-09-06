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

        if (empty($last_att) || ($get_time[0] >= $last_att->date && $get_time[1] < $last_att->time_start)) {

            alert()->warning('Wrong!', 'Đây không phải lúc điểm danh, vui lòng trở lại vào thời gian hợp lệ');
            return redirect()->back();
        } else
        if (empty($last_att) || ($get_time[0] >= $last_att->date && $get_time[1] > $last_att->time_end)) {

            return view('attendances.attend', compact('subjects'));
        } else {

            $lecturer = auth()->user()->id;

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

            foreach ($class as $key => $value) {
                array_push($arr_class, $value->class_id);
            }

            $classes = Classes::whereIn('id', $arr_class)->get();

            return view('attendances.update_attendance', compact(['last_att', 'classes', 'subjects', 'att_details']));
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

        return view('attendances.update_attendance', compact(['last_att', 'classes', 'subjects', 'att_details']));

    }

    public function attendanceHistory()
    {
        alert()->warning('Coming Soon!', 'Tính năng sẽ được cập nhật trong thời gian tới');
        return redirect()->back();
    }

    public function attendanceOver()
    {
        alert()->warning('Coming Soon!', 'Tính năng sẽ được cập nhật trong thời gian tới');
        return redirect()->back();
    }

    public function update(Request $request)
    {
        // return $request;
        $students = DB::table('attendance_details')->where('attendance_id', $request->attendance_id)->get();

        foreach ($students as $key => $value) {
            $student_id = $value->student_id;
            DB::table('attendance_details')->where('student_id', $value->student_id)
                ->where('attendance_id', $request->attendance_id)
                ->update(['status' => $request->$student_id]);
        }
        alert()->success('Thành Công!', 'Cập nhật thành công!');
        return redirect()->route('attend');

    }
}
