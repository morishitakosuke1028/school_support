<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHomeworkRequest;
use App\Http\Requests\UpdateHomeworkRequest;
use App\Models\Homework;
use App\Models\GradeClass;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        $data = $request->validate([
            'grade_class_id' => 'required|integer',
            'homework_day' => 'required',
            'reading' => 'string',
            'language_drill' => 'string',
            'arithmetic' => 'string',
            'diary' => 'string',
            'ipad' => 'max:50|string',
            'other' => 'max:50|string',
        ]);

        $homework = Homework::updateOrCreate(
            ['id' => $id],
            $data
        );

        return to_route('homeworks.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success',
        ]);
    }

    public function bulkStore(Request $request)
    {
        $homeworkEntries = $request->input('homeworkData');

        foreach ($homeworkEntries as $date => $data) {
            $data['homework_day'] = $date; // homework_day をセット
            $data['grade_class_id'] = $request->input('grade_class_id');

            // バリデーション
            Validator::make($data, [
                'grade_class_id' => 'required|integer',
                'homework_day' => 'required',
                'reading' => 'boolean',
                'language_drill' => 'boolean',
                'arithmetic' => 'boolean',
                'diary' => 'boolean',
                'ipad' => 'max:50|string',
                'other' => 'max:50|string',
            ])->validate();

            // ここでデータを保存
            Homework::updateOrCreate(['homework_day' => $date, 'grade_class_id' => $data['grade_class_id']], $data);
        }

        return to_route('homeworks.index')->with([
            'message' => '一括登録が完了しました。',
            'status' => 'success',
        ]);
    }
}
