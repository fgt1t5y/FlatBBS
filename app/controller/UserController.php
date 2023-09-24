<?php

namespace app\controller;

use app\model\User;
use support\Request;

class UserController
{
    public function userbasicinfo(Request $request)
    {
        $session = $request->session();

        return User::getUser(
            $session->get('email'),
            ['id', 'email', 'username', 'avatar_uri']
        );
    }
}
