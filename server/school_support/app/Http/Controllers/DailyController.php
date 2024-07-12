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
use Carbon\Carbon;
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
        $date = $request->input('childDaily', Carbon::today()->toDateString());

        $query = Child::with(['gradeClassHistories.gradeClass', 'dailies' => function ($query) use ($date) {
            $query->whereDate('created_at', $date);
        }]);

        // gradeNameに基づくフィルタリング
        if ($gradeName = $request->input('gradeNames')) {
            $query->whereHas('gradeClassHistories.gradeClass', function ($q) use ($gradeName) {
                $q->where('grade_name', $gradeName);
            });
        }

        // classNameに基づくフィルタリング
        if ($className = $request->input('classNames')) {
            $query->whereHas('gradeClassHistories.gradeClass', function ($q) use ($className) {
                $q->where('class_name', $className);
            });
        }

        // childNameに基づくフィルタリング
        if ($childName = $request->input('childName')) {
            $query->where('name', 'like', '%' . $childName . '%');
        }

        // childKanaに基づくフィルタリング
        if ($childKana = $request->input('childKana')) {
            $query->where('kana', 'like', '%' . $childKana . '%');
        }

        $children = $query->get();
        if ($children->isEmpty()) {
            $allChildren = Child::with('gradeClassHistories.gradeClass')->get();

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
        Daily::processDailies($request->dailies);

        return redirect()->back()
            ->with([
                'message' => '出欠確認の処理が完了しました。',
                'status' => 'success',
            ]);
    }
}
