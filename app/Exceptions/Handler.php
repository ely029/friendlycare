<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    protected function convertExceptionToArray(Throwable $exception)
    {
        $eArray = parent::convertExceptionToArray($exception);
        $jsonMessage = json_decode($eArray['message']);

        if ($jsonMessage !== null) {
            $eArray = array_merge($eArray, (array) $jsonMessage);
        }

        return $eArray;
    }
}
