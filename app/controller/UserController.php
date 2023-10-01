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

        return json_message(0, '完成', $userinfo);
    }
}
