<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;

// @TB
class TrimBigRedirects
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof RedirectResponse) {
            // https://github.com/zaproxy/zap-extensions/wiki/HelpAddonsPscanrulesBetaPscanbeta#big-redirect-detected-potential-sensitive-information-leak
            // https://github.com/zaproxy/zap-extensions/blob/master/addOns/pscanrulesBeta/src/main/java/org/zaproxy/zap/extension/pscanrulesBeta/BigRedirectsScanner.java
            $response->setContent(null);
        }

        return $response;
    }
}
