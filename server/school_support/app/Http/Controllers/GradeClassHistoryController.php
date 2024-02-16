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
    public function edit(Request $request, gradeClassHistory $gradeClassHistory)
    {
        $query = gradeClass::query();

        // 学年でフィルタリング
        if ($request->filled('gradeName')) {
            $gradeNames = $request->input('gradeName');
            if (!is_array($gradeNames)) {
                $gradeNames = [$gradeNames];
            }
            $query->whereIn('grade_name', $gradeNames);
        }

        // クラスでフィルタリング
        if ($request->filled('className')) {
            $classNames = $request->input('className');
            if (!is_array($classNames)) {
                $classNames = [$classNames];
            }
            $query->whereIn('class_name', $classNames);
        }

        $gradeClasses = $query->get();

        // その他のデータを取得
        $children = Child::all();
        $users = User::all();
        $gradeClasses = gradeClass::all();
        $gradeClasseHistories = gradeClassHistory::all();
        $childrenInGradeClass = $gradeClassHistories->pluck('child_id')->flatten()->unique();

        $childrenNotInGradeClass = $children->reject(function ($child) use ($childrenInGradeClass) {
            return $childrenInGradeClass->contains($child->id);
        });

        $gradeNames = $gradeClasses->pluck('grade_name')->unique()->sort()->values();
        $classNames = $gradeClasses->pluck('class_name')->unique()->sort()->values();

        return Inertia::render('GradeClassHistory/Edit', [
            'gradeNames' => $gradeNames,
            'classNames' => $classNames,
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
