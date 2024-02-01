<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\GradeClass;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = event::all();
        $gradeClasses = gradeClass::all();

        return Inertia::render('Event/Index', [
            'events' => $events,
            'gradeClasses' => $gradeClasses,
            'currentUserRole' => Auth::user()->role === 1,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $date = $request->query('date');
        $gradeClassId = $request->query('gradeClassId');
        return Inertia::render('Event/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        Event::create([
            'grade_class_id' => $request->grade_class_id,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'title' => $request->title,
            'place' => $request->place,
            'personal_effect' => $request->personal_effect,
            'content' => $request->content,
        ]);

        return to_route('events.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return Inertia::render('Event/Edit', [
            'event' => $event
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->grade_class_id = $request->grade_class_id;
        $event->start_datetime = $request->start_datetime;
        $event->end_datetime = $request->end_datetime;
        $event->title = $request->title;
        $event->place = $request->place;
        $event->personal_effect = $request->personal_effect;
        $event->content = $request->content;
        $event->save();

        return to_route('events.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success',
        ]);
    }

    public function check(Request $request)
    {
        $date = $request->query('date');
        $gradeClassId = $request->query('gradeClassId');

        $event = Event::whereDate('start_datetime', $date)
            ->where('grade_class_id', $gradeClassId)
            ->first();

        if ($event) {
            return Inertia::location("/events/{$event->id}/edit");
        } else {
            return Inertia::location("/events/create?date={$date}&gradeClassId={$gradeClassId}");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return to_route('events.index')
        ->with([
            'message' => '削除しました。',
            'status' => 'danger',
        ]);
    }
}
