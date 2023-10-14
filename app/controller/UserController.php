<?php

namespace app\controller;

use app\model\User;
use support\Request;
use Shopwwi\LaravelCache\Cache;

class UserController
{
    public function info(Request $request)
    {
        $session = $request->session();
        $uid = $session->get('id');
        $cache_prefix = config('flatbbs.cache.prefix.userinfo');

        $userinfo = Cache::remember(
            "{$cache_prefix}{$uid}",
            config('flatbbs.cache.ttl'),
            function () use ($uid) {
                return User::find($uid, ['id', 'email', 'username', 'avatar_uri'])->toArray();
            }
        );

        return json_message(STATUS_OK, '完成', $userinfo);
    }
}
