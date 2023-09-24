<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\http\Request;
use Webman\http\Response;

class Auth implements MiddlewareInterface
{
    static $needAuthActionList = [
        'app\controller\UserController\userbasicinfo'
    ];

    public function process(Request $request, callable $handle): Response
    {
        if (in_array($request->controller . '\\' . $request->action, self::$needAuthActionList)) {
            $session = $request->session();
            if (!is_login($session, $request->cookie('flat_sess'))) {
                return json_message(401, '请登录');
            } else {
                return $handle($request);
            }
        } else {
            return $handle($request);
        }
    }
}
