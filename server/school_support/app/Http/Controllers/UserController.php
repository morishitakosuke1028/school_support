<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function index()
	{
			$authUserId = Auth::id();
			return Inertia::render('Admin/Index', [
					'users' => User::select('id', 'name', 'tel', 'email', 'role')->paginate(20),
					'authUserId' => $authUserId
			]);
	}
}
