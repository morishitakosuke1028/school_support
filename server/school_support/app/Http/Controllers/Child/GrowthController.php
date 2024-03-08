<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
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
        $growths = Growth::with('child')
            ->orderBy('measurement_month', 'asc')
            ->get();

        return Inertia::render('Child/Growth/Index', [
            'growths' => $growths,
        ]);
    }
}
