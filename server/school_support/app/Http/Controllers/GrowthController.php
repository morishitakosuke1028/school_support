<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrowthRequest;
use App\Http\Requests\UpdateGrowthRequest;
use Inertia\Inertia;
use App\Models\Growth;
use App\Models\Child;
use App\Models\gradeClass;
use App\Models\gradeClassHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GrowthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $children = DB::table('children')
            ->join('grade_class_histories', 'children.id', '=', 'grade_class_histories.child_id')
            ->join('grade_classes', 'grade_class_histories.grade_class_id', '=', 'grade_classes.id')
            ->select('children.*', 'grade_classes.grade_name', 'grade_classes.class_name')
            ->get();

        return Inertia::render('Growth/Index', [
            'children' => $children,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $childId = $request->query('growth');
        $child = Child::find($childId);

        $growths = Growth::where('child_id', $childId)->get();

        return Inertia::render('Growth/Create', [
            'growths' => $growths,
            'child' => $child,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGrowthRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrowthRequest $request)
    {
        Growth::create([
            'child_id' => $request->child_id,
            'height' => $request->height,
            'weight' => $request->weight,
            'chest' => $request->chest,
            'abdomen' => $request->abdomen,
            'head' => $request->head,
            'measurement_month' => $request->measurement_month,
        ]);

        return to_route('growths.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Growth  $growth
     * @return \Illuminate\Http\Response
     */
    public function edit(Growth $growth)
    {
        $child = Child::find($growth->child_id);
        return Inertia::render('Growth/Edit', [
            'growth' => $growth,
            'child' => $child
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGrowthRequest  $request
     * @param  \App\Models\Growth  $growth
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGrowthRequest $request, Growth $growth)
    {
        $growth->child_id = $request->child_id;
        $growth->height = $request->height;
        $growth->weight = $request->weight;
        $growth->chest = $request->chest;
        $growth->abdomen = $request->abdomen;
        $growth->head = $request->head;
        $growth->measurement_month = $request->measurement_month;
        $growth->save();
        return to_route('growths.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Growth  $growth
     * @return \Illuminate\Http\Response
     */
    public function destroy(Growth $growth)
    {
        $growth->delete();
        return to_route('growths.index')
        ->with([
            'message' => '削除しました。',
            'status' => 'danger',
        ]);
    }
}
