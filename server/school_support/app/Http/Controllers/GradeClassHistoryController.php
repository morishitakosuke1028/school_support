<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoregradeClassHistoryRequest;
use App\Http\Requests\UpdategradeClassHistoryRequest;
use App\Models\gradeClassHistory;

class GradeClassHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoregradeClassHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoregradeClassHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\gradeClassHistory  $gradeClassHistory
     * @return \Illuminate\Http\Response
     */
    public function show(gradeClassHistory $gradeClassHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\gradeClassHistory  $gradeClassHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(gradeClassHistory $gradeClassHistory)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\gradeClassHistory  $gradeClassHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(gradeClassHistory $gradeClassHistory)
    {
        //
    }
}
