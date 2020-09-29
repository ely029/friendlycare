<?php

declare(strict_types=1);

use App\Exceptions\HttpApiException;

// @TB: Override existing or add new helper functions
// Overriding requires funkjedi/composer-include-files
// https://laravel-news.com/creating-helpers

// See .htaccess: Filename-based cache busting.
function asset($path, $secure = null)
{
    if (! App::isLocal()) {
        $publicPath = public_path($path);

        if (file_exists($publicPath)) {
            $pattern = '@\.(bmp|css|cur|gif|ico|jpe?g|m?js|png|svgz?|webp|webmanifest)$@i';
            $replacement = '.' . filemtime($publicPath) . '.$1';

            $path = preg_replace($pattern, $replacement, $path);
        }
    }

    return app('url')->asset($path, $secure);
}

function abort($code, $message = '', $docUrl = '', array $headers = [])
{
    throw new HttpApiException($message, $docUrl, null, $code, $headers);
}
