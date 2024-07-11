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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GradeClassHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gradeClasses = GradeClass::with('user')->get();

        $gradeClassHistories = GradeClassHistory::with(['gradeClass', 'child', 'user'])
            ->get()
            ->map(function ($history) {
                return [
                    'grade_class_id' => $history->gradeClass->id,
                    'grade_name' => $history->gradeClass->grade_name,
                    'class_name' => $history->gradeClass->class_name,
                    'user_name' => $history->user->name ?? '',
                ];
            })
            ->groupBy('grade_class_id')
            ->map(function ($group) {
                return $group->first();
            })
            ->values();

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
    // public function edit(gradeClassHistory $gradeClassHistory)
    public function edit($grade_class_id)
    {
        $children = Child::all();
        $users = User::all();
        $gradeClasses = gradeClass::all();
        $gradeClassHistories = gradeClassHistory::all();
        $gradeClassHistory = GradeClassHistory::where('grade_class_id', $grade_class_id)->firstOrFail();
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
    public function update(UpdateGradeClassHistoryRequest $request, GradeClassHistory $gradeClassHistory)
    {
        Log::info('UpdateGradeClassHistoryRequest', $request->all());
        $userId = $request->input('user_id');
        $gradeClassId = $request->input('grade_class_id._value') ?? $request->input('grade_class_id');
        $childIds = $request->input('child_ids._value') ?? $request->input('child_ids', []);

        GradeClassHistory::updateGradeClassHistory($userId, $gradeClassId, $childIds);

        return to_route('gradeClassHistories.index')->with([
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
