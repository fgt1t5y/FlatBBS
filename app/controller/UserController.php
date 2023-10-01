<?php

namespace app\controller;

use app\model\User;
use support\Request;
use Shopwwi\LaravelCache\Cache;

class UserController
{
    public function userbasicinfo(Request $request)
    {
        $session = $request->session();
        $uid = $session->get('uid');

        $userinfo = Cache::remember("userinfo_{$uid}", 1800, function () use ($uid) {
            return User::find($uid, ['id', 'email', 'username', 'avatar_uri'])->toArray();
        });

        return json_message(0, '完成', $userinfo);
    }
}
