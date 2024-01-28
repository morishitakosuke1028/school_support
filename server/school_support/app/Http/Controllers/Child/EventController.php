<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\gradeClassHistory;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $childId = $user->id;

        $gradeClassHistory = GradeClassHistory::where('child_id', $childId)->latest()->first();
        $gradeClassId = optional($gradeClassHistory)->grade_class_id;

        $events = Event::where('grade_class_id', $gradeClassId)->get();

        return Inertia::render('Child/Event/Index', [
            'events' => $events
        ]);
    }
}
