<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDailyRequest;
use App\Http\Requests\UpdateDailyRequest;
use App\Models\Daily;
use App\Models\Child;
use App\Models\GradeClass;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DailyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Child::with('gradeClassHistories.gradeClass', 'dailies');

        // 日付に基づくフィルタリングのチェック
        $date = $request->input('childDaily');
        if ($date) {
            $query->whereHas('dailies', function ($query) use ($date) {
                $query->whereDate('created_at', '=', $date);
            });
        }

        $gradeName = $request->input('gradeName');
        $className = $request->input('className');
        $childName = $request->input('childName');
        $childKana = $request->input('childKana');

        if ($gradeName) {
            $query->whereHas('gradeClassHistories.gradeClass', function ($query) use ($gradeName) {
                $query->where('grade_name', $gradeName);
            });
        }
        if ($className) {
            $query->whereHas('gradeClassHistories.gradeClass', function ($query) use ($className) {
                $query->where('class_name', $className);
            });
        }
        if ($childName) {
            $query->where('name', 'like', '%' . $childName . '%');
        }
        if ($childKana) {
            $query->where('kana', 'like', '%' . $childKana . '%');
        }

        $children = $query->get();
        $gradeClasses = GradeClass::all();

        return Inertia::render('Attendance/Index', [
            'children' => $children,
            'gradeClasses' => $gradeClasses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDailyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDailyRequest $request)
    {
        foreach ($request->dailies as $dailyData) {
            Daily::create([
                'child_id' => $dailyData['child_id'],
                'attendance_status' => $dailyData['attendance_status'],
                'absence_reason' => $dailyData['absence_reason'],
                'start_time' => $dailyData['start_time'],
                'end_time' => $dailyData['end_time'],
                'admin_memo' => $dailyData['admin_memo'],
                'parent_memo' => $dailyData['parent_memo']
            ]);
        }

        return redirect()->back()->with('success', '登下校一覧を作成しました。');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDailyRequest  $request
     * @param  \App\Models\Daily  $daily
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDailyRequest $request, Daily $daily)
    {
        $daily->child_id = $request->child_id;
        $daily->attendance_status = $request->attendance_status;
        $daily->start_time = $request->start_time;
        $daily->end_time = $request->end_time;
        $daily->admin_memo = $request->admin_memo;
        $daily->parent_memo = $request->parent_memo;
        $daily->save();

        return redirect()->back()->with('success', '登下校一覧を更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Daily  $daily
     * @return \Illuminate\Http\Response
     */
    public function destroy(Daily $daily)
    {
        //
    }
}
