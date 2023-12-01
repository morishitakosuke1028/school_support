<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoregradeClassRequest;
use App\Http\Requests\UpdategradeClassRequest;
use App\Models\GradeClass;
use App\Models\GradeClassHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GradeClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $gradeClasses = gradeClass::select('id', 'grade_name', 'class_name', 'created_at', 'updated_at')->paginate(20);

        return Inertia::render('GradeClass/Index', [
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
        return Inertia::render('GradeClass/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoregradeClassRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoregradeClassRequest $request)
    {
        $gradeClass = GradeClass::create([
            'grade_name' => $request->grade_name,
            'class_name' => $request->class_name,
            'school_id' => $request->school_id,
        ]);

        GradeClassHistory::create([
            'grade_class_id' => $gradeClass->id,
        ]);

        return to_route('gradeClasses.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\gradeClass  $gradeClass
     * @return \Illuminate\Http\Response
     */
    public function edit(gradeClass $gradeClass)
    {
        return Inertia::render('GradeClass/Edit', [
            'gradeClass' => $gradeClass
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdategradeClassRequest  $request
     * @param  \App\Models\gradeClass  $gradeClass
     * @return \Illuminate\Http\Response
     */
    public function update(UpdategradeClassRequest $request, gradeClass $gradeClass)
    {
        $gradeClass->grade_name = $request->grade_name;
        $gradeClass->class_name = $request->class_name;
        $gradeClass->save();
        return to_route('gradeClasses.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\gradeClass  $gradeClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(gradeClass $gradeClass)
    {
        $gradeClass->delete();
        return to_route('gradeClasses.index')
        ->with([
            'message' => '削除しました。',
            'status' => 'danger',
        ]);
    }
}
