<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        // 🔥 INI YANG KAMU LUPA
        Inertia::share([
            'auth' => [
                'user' => fn () => Auth::user() ? [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,

                    // penting untuk sidebar permission
                    'permissions' => Auth::user()->getPermissionNames()->toArray(),
                    'roles' => Auth::user()->getRoleNames()->toArray(),
                ] : null,
            ],
        ]);
    }
}