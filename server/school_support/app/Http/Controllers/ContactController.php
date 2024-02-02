<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use Inertia\Inertia;
use App\Models\Contact;
use App\Models\User;
use App\Models\Child;
use App\Models\gradeClass;
use App\Models\gradeClassHistory;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gradeClasses = gradeClass::all();
        $gradeClassHistories = gradeClassHistory::all();
        $children = child::all();
        // $children = Child::with('gradeClassHistory.gradeClass')->get();

        return Inertia::render('Contact/Index', [
            'gradeClasses' => $gradeClasses,
            'gradeClassHistories' => $gradeClassHistories,
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
        // @TODO
        $contacts = contact::all();
        $user = user::all();
        $child = child::all();
        return Inertia::render('Contact/Create', [
            'contacts' => $contacts,
            'user' => $user,
            'child' => $child,
            'currentUserRole' => Auth::user()->role === 1,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
