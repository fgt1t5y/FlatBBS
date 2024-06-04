<?php

namespace support;

use Throwable;
use Webman\Http\Request;
use Webman\Http\Response;
use PDOException;

class Exception extends \Webman\Exception\ExceptionHandler
{
    public function render(Request $request, Throwable $exception): Response
    {
        Log::error($exception->getMessage());

        if ($exception instanceof PDOException) {
            return no(STATUS_INTERNAL_ERROR, 'Database Internal Error');
        }

        if ($exception instanceof Throwable) {
            return no(STATUS_INTERNAL_ERROR, 'Backend Error');
        }

        return parent::render($request, $exception);
    }
}
