<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\GradeClass;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ScheduleRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gradeClasses = gradeClass::select('id', 'grade_name', 'class_name')->paginate(20);

        return Inertia::render('Schedule/Index', [
            'gradeClasses' => $gradeClasses,
            'currentUserRole' => Auth::user()->role === 1,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit($gradeClassId)
    {
        $gradeClass = GradeClass::findOrFail($gradeClassId);
        $subjects = subject::select('id', 'name')->get();
        $schedules = Schedule::where('grade_class_id', $gradeClassId)->get();

        return Inertia::render('Schedule/Edit', [
            'gradeClassId' => (int)$gradeClassId,
            'gradeClass' => $gradeClass,
            'subjects' => $subjects,
            'schedules' => $schedules
        ]);
    }

    public function bulkStore(ScheduleRequest $request)
    {
        $scheduleEntries = $request->input('scheduleData');

        DB::beginTransaction();

        try {
            Schedule::bulkStore($scheduleEntries);
            DB::commit();

            return to_route('schedules.index')->with([
                'message' => '一括登録が完了しました。',
                'status' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during bulk store:', ['exception' => $e]);

            return back()->with([
                'message' => '登録に失敗しました。',
                'status' => 'error',
            ]);
        }
    }
}
