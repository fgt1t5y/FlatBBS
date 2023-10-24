<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\http\Request;
use Webman\http\Response;

// Allow cross site
class Access implements MiddlewareInterface
{
    public function process(Request $request, callable $handle): Response
    {
        return $request->method() == 'OPTIONS' ? response('') : $handle($request);
    }
}
