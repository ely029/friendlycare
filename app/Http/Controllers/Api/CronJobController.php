<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Artisan;
use Illuminate\Http\Request;
use Str;
use Symfony\Component\HttpFoundation\Response;

class CronJobController extends Controller
{
    /**
     * Scheduling Jobs with App Engine
     *
     * On instances where the application is hosted on Google Cloud's App
     * Engine, cron jobs can only be implemented through invoking a URL. By
     * default, ThinkBIT's CI/CD will use the API to trigger scheduled tasks.
     *
     * Related guide: [Validating cron requests](https://cloud.google.com/appengine/docs/flexible/php/scheduling-jobs-with-cron-yaml#validating_cron_requests).
     *
     * @authenticated
     * @response 204 ''
     * @response 401 {
     *     "message": "Request did not contain a valid HTTP header."
     * }
     * @response 403 {
     *     "message": "Cron request did not come from a valid IP address."
     * }
     */
    public function run(Request $request)
    {
        if ($request->header('x-appengine-cron', 'false') !== 'true') {
            return abort(Response::HTTP_UNAUTHORIZED, 'Request did not contain a valid HTTP header.');
        }

        if (! Str::contains($request->header('x-forwarded-for', ''), '10.0.0.1')) {
            return abort(Response::HTTP_FORBIDDEN, 'Cron request did not come from a valid IP address.');
        }

        Artisan::call('schedule:run');

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
