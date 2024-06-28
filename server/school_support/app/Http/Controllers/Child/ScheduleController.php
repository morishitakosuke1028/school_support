<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\GradeClassHistory;

class ScheduleController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $childId = $user->id;

        $gradeClassHistory = GradeClassHistory::where('child_id', $childId)->latest()->first();
        $gradeClassId = optional($gradeClassHistory)->grade_class_id;

        $schedules = Schedule::where('grade_class_id', $gradeClassId)->get();
        $subjects = subject::select('id', 'name')->get();

        // dd($schedules);

        return Inertia::render('Child/Schedule/Index', [
            'schedules' => $schedules,
            'subjects' => $subjects,
        ]);
    }
}
