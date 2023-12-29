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
    public function index()
    {
        $children = Child::with('gradeClassHistories.gradeClass', 'dailies')->get();
        $gradeClasses = GradeClass::all();

        // dd($children);

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
        // @TODO　ひとまず作成処理
        $daily = new Daily();
        $daily->fill($request->all());
        $daily->save();

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
        // @TODO ひとまず更新処理
        $daily = Daily::findOrFail($id);
        $daily->fill($request->all());
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
