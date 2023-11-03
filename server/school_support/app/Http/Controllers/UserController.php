<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
	public function showChildRegisterForm()
	{
		return Inertia::render('Child/Auth/Register');
	}
}
