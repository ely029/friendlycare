<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            // @TB: We use dashboard since it is business centric.
            return redirect(RouteServiceProvider::HOME);
        }

        // @TB: Some requirements do not allow public sign up.
        if ($request->is('register') && ! config('boilerplate.membership')) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
