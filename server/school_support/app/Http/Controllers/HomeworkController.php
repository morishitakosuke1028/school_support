<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\GradeClass;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\HomeworkRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gradeClasses = gradeClass::select('id', 'grade_name', 'class_name')->paginate(20);

        return Inertia::render('Homework/Index', [
            'gradeClasses' => $gradeClasses,
            'currentUserRole' => Auth::user()->role === 1,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function edit($gradeClassId)
    {
        $gradeClass = GradeClass::findOrFail($gradeClassId);
        $homeworks = Homework::where('grade_class_id', $gradeClassId)->get();
        return Inertia::render('Homework/Edit', [
            'gradeClass' => $gradeClass,
            'homeworks' => $homeworks
        ]);
    }

    public function bulkStore(HomeworkRequest $request)
    {
        $homeworkEntries = $request->input('homeworkData');

        Homework::bulkStore($homeworkEntries);

        return to_route('homeworks.index')->with([
            'message' => '一括登録が完了しました。',
            'status' => 'success',
        ]);
    }
}
