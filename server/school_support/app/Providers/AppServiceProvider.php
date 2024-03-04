<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inertia::share([
            'auth' => function (Request $request) {
                return [
                    'user' => $request->user('children') ? $request->user('children')->only('id', 'name', 'email') : null,
                ];
            },
        ]);
        if (request()->is('child.*')) {
            config(['session.cookie' => config('session.cookie_child')]);
    	}
    }
}
