<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChildDailyRequest;
use Inertia\Inertia;
use App\Models\Daily;
use Illuminate\Support\Facades\Auth;

class DailyController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $childId = Auth::id();

        return Inertia::render('Child/Daily/Create', [
            'childId' => $childId,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoregradeClassRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChildDailyRequest $request)
    {
        $daily = Daily::firstOrCreate(
            [
                'child_id' => $request->child_id,
                'date_use' => $request->date_use,
            ],
            [
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'attendance_status' => $request->attendance_status,
                'absence_reason' => $request->absence_reason,
                'parent_memo' => $request->parent_memo,
                'entry_method' => $request->entry_method,
            ]
        );

        if (!$daily->wasRecentlyCreated) {
            $daily->update([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'attendance_status' => $request->attendance_status,
                'absence_reason' => $request->absence_reason,
                'parent_memo' => $request->parent_memo,
                'update_method' => $request->update_method,
            ]);
        }

        return to_route('child.daily.create')
        ->with([
            'message' => '申請しました。',
            'status' => 'success'
        ]);
    }
}
