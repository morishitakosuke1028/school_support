<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Homework;
use App\Models\GradeClass;

class HomeworkController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $gradeClassId = $user->grade_class_id;
        $homeworks = Homework::where('grade_class_id', $gradeClassId)->get();

        return Inertia::render('Homework/Index', [
            'homeworks' => $homeworks
        ]);
    }
}
