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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
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

        return Inertia::render('Contact/Index', [
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
        $childId = $request->query('contact');
        $child = Child::find($childId);

        $contacts = Contact::all();

        return Inertia::render('Contact/Create', [
            'contacts' => $contacts,
            'child' => $child,
            'currentUserRole' => Auth::user()->role === 1,
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
    public function store(StoreContactRequest $request)
    {
        Contact::create([
            'user_id' => $request->user_id,
            'child_id' => $request->child_id,
            'sender' => $request->sender,
            'content' => $request->content,
        ]);

        return to_route('contacts.index')
        ->with([
            'message' => '送信しました。',
            'status' => 'success',
        ]);
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
