<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function showClass()
    {
        if (request()->ajax()) {
            $lecturer = auth()->user()->id;
            $subject = request()->subject_id;

            $classes = Assignment::join('subjects', 'subjects.id', '=', 'assignments.subject_id')
                ->join('classes', 'classes.id', '=', 'assignments.class_id')
                ->where('subject_id', $subject)
                ->where('lecturer_id', $lecturer)
                ->get(['classes.id', 'class_name']);

            return response()->json($classes);
        }
    }
}
