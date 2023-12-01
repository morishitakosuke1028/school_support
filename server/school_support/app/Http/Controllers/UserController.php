<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
	public function index(Request $request)
	{
        $users = User::select('id', 'name', 'tel', 'email', 'role')->paginate(20);

        return Inertia::render('Admin/Index', [
            'users' => $users,
            'currentUserRole' => Auth::user()->role === 1,
        ]);
	}

    public function edit(User $user)
    {
        return Inertia::render('Admin/Edit', [
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->kana = $request->kana;
        $user->email = $request->email;
        $user->tel = $request->tel;
        $user->role = $request->role;
        $user->retirement_date = $request->retirement_date;
        $user->session_id = $request->session_id;
        $user->save();
        return to_route('users.index')
        ->with([
            'message' => '更新しました。',
            'status' => 'success',
        ]);
    }

}
