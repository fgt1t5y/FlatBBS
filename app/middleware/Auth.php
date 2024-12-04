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
        $session = $request->session();
        $reflection = new \ReflectionClass($request->controller);
        $attr = $reflection->getMethod($request->action)->getAttributes(Gate::class);

        if (count($attr)) {
            $permission_required = $attr[0]->getArguments();

            if (count($permission_required) === 0) {
                return no(STATUS_INTERNAL_ERROR);
            }

            $permission_required = $permission_required[0];

            if (!$session->has('id')) {
                return no(STATUS_UNAUTHORIZED, 'Login please');
            }

            if (in_array($permission_required, $session->get('permissions'))) {
                return $handle($request);
            } else {
                return no(STATUS_FORBIDDEN, 'Forbidden');
            }
        }

        return $handle($request);
    }
}
