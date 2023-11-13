<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoregradeClassRequest;
use App\Http\Requests\UpdategradeClassRequest;
use App\Models\gradeClass;
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
        // $pageNumber = $request->input('page', 1); // デフォルトのページ番号を1に設定
        // \Log::info('Requested page number: ' . $pageNumber);

        $gradeClasses = gradeClass::select('id', 'grade_name', 'class_name', 'created_at', 'updated_at')->paginate(50);

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
        GradeClass::create([
            'grade_name' => $request->grade_name,
            'class_name' => $request->class_name,
            'school_id' => $request->school_id,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\gradeClass  $gradeClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(gradeClass $gradeClass)
    {
        //
    }
}
