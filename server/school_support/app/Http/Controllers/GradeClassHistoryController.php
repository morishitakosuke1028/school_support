<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoregradeClassHistoryRequest;
use App\Http\Requests\UpdategradeClassHistoryRequest;
use App\Models\gradeClassHistory;
use App\Models\gradeClass;
use App\Models\User;
use App\Models\Child;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class GradeClassHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gradeClassHistories = GradeClassHistory::with(['gradeClass' => function ($query) {
            $query->select('id', 'class_name', 'grade_name');
        }, 'user' => function ($query) {
            $query->select('id', 'name');
        }])
        ->select('id', 'grade_class_id', 'user_id')
        ->get();

        $gradeClasses = GradeClass::all();
        $children = Child::all();
        $users = User::all();

        return Inertia::render('GradeClassHistory/Index', [
            'gradeClassHistories' => $gradeClassHistories,
            'gradeClasses' => $gradeClasses,
            'children' => $children,
            'users' => $users,
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
     * @param  \App\Http\Requests\StoregradeClassHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoregradeClassHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\gradeClassHistory  $gradeClassHistory
     * @return \Illuminate\Http\Response
     */
    public function show(gradeClassHistory $gradeClassHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\gradeClassHistory  $gradeClassHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(gradeClassHistory $gradeClassHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdategradeClassHistoryRequest  $request
     * @param  \App\Models\gradeClassHistory  $gradeClassHistory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdategradeClassHistoryRequest $request, gradeClassHistory $gradeClassHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\gradeClassHistory  $gradeClassHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(gradeClassHistory $gradeClassHistory)
    {
        //
    }
}
