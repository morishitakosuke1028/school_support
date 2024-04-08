<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
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

    public function store(StoreSubjectRequest $request)
    {
        $subject = Subject::create([
            'name' => $request->name,
        ]);

        return to_route('subjects.index')
        ->with([
            'message' => '登録しました。',
            'status' => 'success'
        ]);
    }

    public function edit(subject $subject)
    {
        return Inertia::render('Subject/Edit', [
            'subject' => $subject
        ]);
    }

    public function update(UpdateSubjectRequest $request, subject $subject)
    {
        $subject->name = $request->name;
        $subject->save();
        return to_route('subjects.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success',
        ]);
    }

    public function destroy(subject $subject)
    {
        $subject->delete();
        return to_route('subjects.index')
        ->with([
            'message' => '削除しました。',
            'status' => 'danger',
        ]);
    }
}
