<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Str;

class ForceSecure
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (App::environment(['local', 'testing'])) {
            return $next($request);
        }

        if ($request->isSecure()) {
            return $next($request);
        }

        // This is only used with GCP installations.
        // Else, refer to htaccess for better performance.
        if (! Str::endsWith($request->header('via', ''), 'google')) {
            return $next($request);
        }

        // App Engine Cron jobs do not follow redirects!
        if ($request->is('api/cron')) {
            return $next($request);
        }

        return redirect(
            $request->getRequestUri(),
            Response::HTTP_FOUND,
            $request->headers->all(),
            true
        );
    }
}
