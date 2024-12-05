<?php

namespace app\middleware;

use Webman\MiddlewareInterface;
use Webman\http\Request;
use Webman\http\Response;

class Auth implements MiddlewareInterface
{
    public function process(Request $request, callable $handle): Response
    {
        $session = $request->session();
        $reflection = new \ReflectionClass($request->controller);
        try {
            $attrs = $reflection->getMethod($request->action)->getAttributes();
        } catch (\ReflectionException) {
            return no(STATUS_INTERNAL_ERROR);
        }

        if (count($attrs) === 0) {
            return $handle($request);
        }

        $pass_flags = [];

        foreach ($attrs as $attr) {
            /**
             * @var \support\Guard
             */
            $gate = $attr->newInstance();

            if ($gate instanceof \support\Guard && $gate->check($request)) {
                $pass_flags[] = true;
            }
        }

        if (count($pass_flags) === count($attrs)) {
            return $handle($request);
        } else {
            return no(STATUS_FORBIDDEN);
        }
    }
}
