<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChildContactRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Contact;
use App\Models\User;
use App\Models\Child;
use App\Models\GradeClassHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $childId = Auth::user()->id;
        $child = Child::find($childId);

        $contacts = Contact::where('child_id', $childId)->get();

        $gradeClassHistory = GradeClassHistory::where('child_id', $childId)->first();
        $user_id = $gradeClassHistory ? $gradeClassHistory->user_id : null;

        return Inertia::render('Child/Contact/Create', [
            'contacts' => $contacts,
            'child' => $child,
            'user_id' => $user_id,
            'currentUser' => Auth::user()->id,
            'currentUserName' => Auth::user()->name,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChildContactRequest $request)
    {
        Contact::create([
            'user_id' => $request->user_id,
            'child_id' => $request->child_id,
            'sender' => $request->sender,
            'content' => $request->content,
        ]);

        return to_route('child.dashboard')
        ->with([
            'message' => '送信しました。',
            'status' => 'success',
        ]);
    }
}
