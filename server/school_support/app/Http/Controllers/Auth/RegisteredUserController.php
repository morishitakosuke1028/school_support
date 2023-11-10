<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'kana' => 'nullable|string|max:255|regex:/^[\p{Hiragana}\s]+$/u',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'tel' => 'nullable|string|max:13',
            'role' => 'required|in:1,2',
            'retirement_date' => 'nullable|date_format:Y-m-d',
            'session_id' => 'required|string|max:255',
            'school_id' => 'required|string',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'kana' => $request->kana,
            'email' => $request->email,
            'tel' => $request->tel,
            'role' => $request->role,
            'retirement_date' => $request->retirement_date,
            'session_id' => $request->session_id,
            'school_id' => $request->school_id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
