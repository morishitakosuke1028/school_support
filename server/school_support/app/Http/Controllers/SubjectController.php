<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $subjects = subject::select('id', 'name', 'created_at')->paginate(20);

        return Inertia::render('Subject/Index', [
            'subjects' => $subjects,
            'currentUserRole' => Auth::user()->role === 1,
        ]);
    }

    public function create()
    {
        return Inertia::render('Subject/Create');
    }
}
