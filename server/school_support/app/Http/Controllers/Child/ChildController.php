<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Child;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChildController extends Controller
{
    public function index()
    {
        $child = Child::find(Auth::guard('child')->id());

        return view('child.daily.create', compact('child'));
    }
}
