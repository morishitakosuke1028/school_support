<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Homework;
// use App\Models\GradeClass;
use App\Models\GradeClassHistory;

class HomeworkController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $childId = $user->id;

        $gradeClassHistory = GradeClassHistory::where('child_id', $childId)->latest()->first();
        $gradeClassId = optional($gradeClassHistory)->grade_class_id;

        $homeworks = Homework::where('grade_class_id', $gradeClassId)->get();

        return Inertia::render('Child/Homework/Index', [
            'homeworks' => $homeworks
        ]);
    }
}
