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
use Illuminate\Support\Facades\Validator;
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

    public function bulkStore(Request $request)
    {
        \Log::info($request->all());

        $scheduleEntries = $request->input('scheduleData');

        foreach ($scheduleEntries as $date => $data) {
            $data['schedule_day'] = $date;
            $validator = Validator::make($data, [
                'grade_class_id' => 'required|integer',
                'schedule_day' => 'required',
                'subject_id_first' => 'nullable|string',
                'subject_id_second' => 'nullable|string',
                'subject_id_third' => 'nullable|string',
                'subject_id_fourth' => 'nullable|string',
                'subject_id_five' => 'nullable|string',
                'subject_id_six' => 'nullable|string',
                'subject_id_other' => 'nullable|string',
                'subject_id_all_check' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // ここでデータを保存
            Schedule::updateOrCreate(['schedule_day' => $date, 'grade_class_id' => $data['grade_class_id']], $data);
        }

        return to_route('schedules.index')->with([
            'message' => '一括登録が完了しました。',
            'status' => 'success',
        ]);
    }
}
