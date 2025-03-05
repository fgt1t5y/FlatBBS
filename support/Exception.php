<?php

namespace support;

use Throwable;
use Webman\Http\Request;
use Webman\Http\Response;
use support\Log;
use support\exception\UnauthorizedException;
use support\exception\ForbiddenException;
use support\exception\BadRequestException;
use Webman\Exception\ExceptionHandler;

class Exception extends ExceptionHandler
{
    public function report(Throwable $exception)
    {
        Log::error($exception->getMessage());
    }

    public function render(Request $request, Throwable $exception): Response
    {
        if ($exception instanceof UnauthorizedException) {
            return no(STATUS_UNAUTHORIZED, '$exception.unauthorized');
        }

        if ($exception instanceof ForbiddenException) {
            return no(STATUS_FORBIDDEN, '$exception.forbidden');
        }

        if ($exception instanceof BadRequestException) {
            return no(STATUS_BAD_REQUEST, $exception->getMessage());
        }

        if ($exception instanceof Throwable) {
            return no(STATUS_INTERNAL_ERROR, '$exception.server_internal_error');
        }

        return parent::render($request, $exception);
    }
}
