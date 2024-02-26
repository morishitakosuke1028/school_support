<?php

namespace App\Http\Controllers\Child\Auth;

use App\Http\Controllers\Controller;
use App\Models\Child;
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
        return Inertia::render('Child/Auth/Register');
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
            'email' => 'required|string|email|max:255|unique:'.child::class,
            'zip' => 'nullable|digits:7',
            'address' => 'nullable|string|max:255',
            'tel' => 'required|string|max:13',
            'gender' => 'required|in:1,2',
            'admission_date' => 'required|date_format:Y-m-d',
            'birthday' => 'nullable|date_format:Y-m-d',
            'pin_code' => 'required|string|max:255',
            'session_id' => 'required|string|max:255',
            'school_id' => 'required|string',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Child::create([
            'name' => $request->name,
            'kana' => $request->kana,
            'zip' => $request->zip,
            'address' => $request->address,
            'tel' => $request->tel,
            'email' => $request->email,
            'gender' => $request->gender,
            'admission_date' => $request->admission_date,
            'birthday' => $request->birthday,
            'pin_code' => $request->pin_code,
            'session_id' => $request->session_id,
            'school_id' => $request->school_id,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
