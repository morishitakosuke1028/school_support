<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDailyRequest;
use App\Models\Daily;
use App\Models\Child;
use App\Models\GradeClass;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DailyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        DB::enableQueryLog();
        $query = Child::with('gradeClassHistories.gradeClass', 'dailies');

        $date = $request->input('childDaily');
        $query->whereHas('dailies', function ($query) use ($date) {
            $query->whereDate('created_at', $date);
        });

        $gradeName = $request->input('gradeName');
        $className = $request->input('className');
        $childName = $request->input('childName');
        $childKana = $request->input('childKana');

        if ($gradeName = $request->input('gradeName')) {
            $query->whereHas('gradeClassHistories.gradeClass', function ($q) use ($gradeName) {
                $q->where('grade_name', $gradeName);
            });
        }

        if ($className = $request->input('className')) {
            $query->whereHas('gradeClassHistories.gradeClass', function ($q) use ($className) {
                $q->where('class_name', $className);
            });
        }

        if ($childName) {
            $query->where('name', 'like', '%' . $childName . '%');
        }
        if ($childKana) {
            $query->where('kana', 'like', '%' . $childKana . '%');
        }

        $children = $query->get();
        if ($children->isEmpty()) {
            $allChildren = Child::with('gradeClassHistories.gradeClass')->get();

            // 各生徒に対して新規登録用の空のdailiesデータを用意
            foreach ($allChildren as $child) {
                $child->dailies = (object)[
                    'child_id' => $child->id,
                    'attendance_status' => null,
                    'absence_reason' => '',
                    'start_time' => '',
                    'end_time' => '',
                    'admin_memo' => '',
                    'parent_memo' => '',
                    'date_use' => '',
                    'entry_method' => '',
                ];
            }

            $children = $allChildren;
        }
        $gradeClasses = GradeClass::all();

        $queryLog = DB::getQueryLog();
        Log::info($queryLog);

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
            if (isset($dailyData['id']) && $daily = Daily::find($dailyData['id'])) {
                // 既存レコードの更新
                $daily->update([
                    'child_id' => $dailyData['child_id'],
                    'attendance_status' => $dailyData['attendance_status'],
                    'absence_reason' => $dailyData['absence_reason'],
                    'start_time' => $dailyData['start_time'],
                    'end_time' => $dailyData['end_time'],
                    'admin_memo' => $dailyData['admin_memo'],
                    'parent_memo' => $dailyData['parent_memo'],
                    'date_use' => $dailyData['date_use'],
                    'update_method' => $dailyData['update_method']
                ]);
            } else {
                // 新規レコードの作成
                Daily::create([
                    'child_id' => $dailyData['child_id'],
                    'attendance_status' => $dailyData['attendance_status'],
                    'absence_reason' => $dailyData['absence_reason'],
                    'start_time' => $dailyData['start_time'],
                    'end_time' => $dailyData['end_time'],
                    'admin_memo' => $dailyData['admin_memo'],
                    'parent_memo' => $dailyData['parent_memo'],
                    'date_use' => $dailyData['date_use'],
                    'entry_method' => $dailyData['entry_method'],
                ]);
            }
        }

        return redirect()->back()
        ->with([
            'message' => '出欠確認の処理が完了しました。',
            'status' => 'success',
        ]);
    }
}
