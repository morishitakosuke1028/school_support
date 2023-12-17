<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHomeworkRequest;
use App\Http\Requests\UpdateHomeworkRequest;
use App\Models\Homework;
use App\Models\GradeClass;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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
     * @param  \App\Http\Requests\StoreHomeworkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHomeworkRequest $request)
    {
        //
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
        $homework = Homework::all();
        return Inertia::render('Homework/Edit', [
            'gradeClass' => $gradeClass,
            'homework' => $homework
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHomeworkRequest  $request
     * @param  \App\Models\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHomeworkRequest $request, Homework $homework)
    {
        $homework->grade_class_id = $request->grade_class_id;
        $homework->homework_day = $request->homework_day;
        $homework->reading = $request->reading;
        $homework->language_drill = $request->language_drill;
        $homework->arithmetic = $request->arithmetic;
        $homework->diary = $request->diary;
        $homework->ipad = $request->ipad;
        $homework->other = $request->other;
        $homework->save();
        return to_route('homeworks.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success',
        ]);
    }

    public function updateOrCreate(Request $request, $id = null)
    {
        $homework = Homework::updateOrCreate(
            ['id' => $id],
            $data
        );

        return redirect()->route('homeworks.index')->with('success', '登録が完了しました。');
    }
}
