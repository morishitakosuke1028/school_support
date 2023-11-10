<?php

namespace App\Http\Controllers;

use App\Http\Requests\Storegrade_classesRequest;
use App\Http\Requests\Updategrade_classesRequest;
use App\Models\grade_classes;

class GradeClassesController extends Controller
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
     * @param  \App\Http\Requests\Storegrade_classesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storegrade_classesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\grade_classes  $grade_classes
     * @return \Illuminate\Http\Response
     */
    public function show(grade_classes $grade_classes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\grade_classes  $grade_classes
     * @return \Illuminate\Http\Response
     */
    public function edit(grade_classes $grade_classes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updategrade_classesRequest  $request
     * @param  \App\Models\grade_classes  $grade_classes
     * @return \Illuminate\Http\Response
     */
    public function update(Updategrade_classesRequest $request, grade_classes $grade_classes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\grade_classes  $grade_classes
     * @return \Illuminate\Http\Response
     */
    public function destroy(grade_classes $grade_classes)
    {
        //
    }
}
