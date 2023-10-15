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
        // $response = $request->method() == 'OPTIONS' ? response('') : $handle($request);
        return $response = $request->method() == 'OPTIONS' ? response('') : $handle($request);
        //     if ($request->method() === 'GET') {
        //         return $response;
        //     }
        //     $response->withHeaders([
        //         'Access-Control-Allow-Origin' =>            $request->header('Origin', '*'),
        //         'Access-Control-Allow-Credentials' =>       'true',
        //         'Content-Type' =>                           'application/json;charset=UTF-8',
        //         'Access-Control-Allow-Methods' =>           '*',
        //         'Access-Control-Allow-Headers' =>           'Content-Type,XFILENAME,XFILECATEGORY,XFILESIZE'
        //     ]);
        //     return $response;
    }
}
