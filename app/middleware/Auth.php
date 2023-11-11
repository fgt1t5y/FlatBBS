<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\http\Request;
use Webman\http\Response;

class Auth implements MiddlewareInterface
{
    static $needAuthActionList = [
        'app\controller\UserController\info',
        'app\controller\UserController\modify',
        'app\controller\FileController\upload',
        'app\controller\TopicController\create'
    ];

    public function process(Request $request, callable $handle): Response
    {
        if (in_array("$request->controller\\$request->action", self::$needAuthActionList)) {
            if (!is_login($request->cookie('flat_sess'))) {
                return json_message(STATUS_UNAUTHORIZED, '令牌过期，请登录');
            }
        }

        return $handle($request);
    }
}
