<?php

namespace app\controller;

use app\model\User;
use support\Request;

class UserController
{
    public function userbasicinfo(Request $request)
    {
        $session = $request->session();

        $userinfo = User::find(
            $session->get('uid'),
            ['id', 'email', 'username', 'avatar_uri']
        );

        return json([
            'code' => 0,
            'data' => $userinfo,
            'message' => '完成',
        ]);
    }
}
