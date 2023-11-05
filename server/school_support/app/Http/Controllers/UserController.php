<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
	public function index(Request $request)
	{
            $pageNumber = $request->input('page', 1); // デフォルトのページ番号を1に設定
            \Log::info('Requested page number: ' . $pageNumber);

			$authUserId = Auth::id();
            $users = User::select('id', 'name', 'tel', 'email', 'role')->paginate(50);

            // dd($users);
			return Inertia::render('Admin/Index', [
					'users' => $users,
					'authUserId' => $authUserId
			]);
	}
}
