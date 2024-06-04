<?php

namespace app\middleware;

use support\Gate;
use Webman\MiddlewareInterface;
use Webman\http\Request;
use Webman\http\Response;

class Auth implements MiddlewareInterface
{
    public function process(Request $request, callable $handle): Response
    {
        $authed = is_login($request->cookie('flat_sess'));
        $reflection = new \ReflectionClass($request->controller);
        $attr = $reflection->getMethod($request->action)->getAttributes(Gate::class);

        if (count($attr)) {
            $need_auth = $attr[0]->getArguments()[0] ?? true;
            if ($need_auth === true && $authed !== true) {
                return no(STATUS_UNAUTHORIZED, '请登录');
            }
        }

        return $handle($request);
    }
}
