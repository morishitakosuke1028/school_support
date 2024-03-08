<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $guard = null;
        foreach (array_keys(config('auth.guards')) as $guardName) {
            if ($request->user($guardName)) {
                $guard = $guardName;
                break;
            }
        }

        $user = $guard ? $request->user($guard) : null;
        if (is_null($user)) {
            $user = $request->user('child');
        }

        return array_merge(parent::share($request), [
            'auth' => [
                'user'=> [
                    'name' => function() {
                        return auth()->user() ? auth()->user()->name : null;
                    }
                ]
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'message' => fn() => $request->session()->get('message'),
                'status' => fn() => $request->session()->get('status')
            ],
        ]);

        Inertia::share([
            'auth' => function () {
                return [
                    'user' => Auth::guard('child')->user() ? Auth::guard('child')->user()->only('id', 'name', 'email') : null,
                ];
            },
        ]);
    }
}
