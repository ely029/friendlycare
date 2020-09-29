<?php

declare(strict_types=1);

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

// @TB: See abort() in helpers.php
class HttpApiException extends HttpException
{
    public function __construct(string $message = '', string $docUrl = '', ?\Throwable $previous = null, int $code = 0, array $headers = [])
    {
        // @TB: Based on https://stripe.com/docs/api/errors

        $messageArray = [];

        if ($message !== '') {
            $messageArray['message'] = $message;
        }

        if ($docUrl !== '' && config('app.debug')) {
            $messageArray['doc_url'] = $docUrl;
        }

        parent::__construct($code, json_encode($messageArray), $previous, $headers, $code);
    }
}
