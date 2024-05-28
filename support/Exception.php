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
            return json(['code' => 500, 'message' => 'Database Internal Error']);
        }

        if ($exception instanceof Throwable) {
            return json(['code' => 500, 'message' => 'Backend Error']);
        }

        return parent::render($request, $exception);
    }
}
