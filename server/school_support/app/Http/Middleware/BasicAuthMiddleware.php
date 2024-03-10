<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Child;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->getUser() && $request->getPassword()) {
            $session_id = $request->getUser();
            $pinCode = $request->getPassword();

            $user = Child::where('session_id', $session_id)
                        ->where('pin_code', $pinCode)
                        ->first();

            if ($user) {
                Auth::login($user);
                return $next($request);
            }
        }

        $headers = ['WWW-Authenticate' => 'Basic'];
        return response('Unauthorized', 401, $headers);
    }
}
