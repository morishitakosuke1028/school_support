<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoregradeClassHistoryRequest;
use App\Http\Requests\UpdategradeClassHistoryRequest;
use App\Models\GradeClassHistory;
use App\Models\GradeClass;
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\gradeClassHistory  $gradeClassHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(gradeClassHistory $gradeClassHistory)
    {
        $children = Child::all();
        $users = User::all();
        $gradeClasses = gradeClass::all();
        $gradeClassHistories = gradeClassHistory::all();
        $childrenInGradeClass = gradeClassHistory::pluck('child_id')->flatten()->unique()->toArray();

        $childrenNotInGradeClass = $children->reject(function ($child) use ($childrenInGradeClass) {
            return in_array($child->id, $childrenInGradeClass);
        });

        return Inertia::render('GradeClassHistory/Edit', [
            'gradeClassHistory' => $gradeClassHistory,
            'children' => $children,
            'users' => $users,
            'gradeClasses' => $gradeClasses,
            'gradeClassHistories' => $gradeClassHistories,
            'childrenNotInGradeClass' => $childrenNotInGradeClass,
            'childrenInGradeClass' => $childrenInGradeClass
        ]);
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
        $gradeClassHistory->user_id = $request->user_id;
        $gradeClassHistory->child_id = $request->child_id;
        $gradeClassHistory->save();
        return to_route('gradeClassHistories.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\gradeClassHistory  $gradeClassHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(gradeClassHistory $gradeClassHistory)
    {
        $gradeClassHistory->delete();
        return to_route('gradeClassHistories.index')
        ->with([
            'message' => '削除しました。',
            'status' => 'danger',
        ]);
    }
}
