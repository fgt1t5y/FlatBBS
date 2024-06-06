<?php

namespace support;

use Throwable;
use Webman\Http\Request;
use Webman\Http\Response;
use PDOException;

class Exception extends \Webman\Exception\ExceptionHandler
{
    public function report(Throwable $exception)
    {
        Log::error($exception->getMessage());
    }

    public function render(Request $request, Throwable $exception): Response
    {
        if ($exception instanceof PDOException) {
            return no(STATUS_INTERNAL_ERROR, 'Database Internal Error');
        }

        if ($exception instanceof Throwable) {
            return no(STATUS_INTERNAL_ERROR, 'Backend Error');
        }

        return parent::render($request, $exception);
    }
}
