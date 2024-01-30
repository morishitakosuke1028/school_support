<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Event;
use App\Models\gradeClassHistory;
use App\Models\gradeClass;
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

        $gradeClasses = gradeClass::all();

        return Inertia::render('Child/Event/Index', [
            'gradeClasses' => $gradeClasses,
            'events' => $events
        ]);
    }

    public function show(Event $event)
    {
        return Inertia::render('Child/Event/Show', [
            'event' => $event
        ]);
    }
}
