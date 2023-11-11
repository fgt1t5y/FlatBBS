<?php

namespace app\controller;

use app\model\User;
use support\Request;
use Shopwwi\LaravelCache\Cache;

class UserController
{
    static $userInfo = [
        'id',
        'email',
        'username',
        'avatar_uri',
        'introduction'
    ];

    public function info(Request $request)
    {
        $session = $request->session();
        $uid = $session->get('id');
        $cache_prefix = config('flatbbs.cache.prefix.userinfo');

        $userinfo = Cache::remember(
            "{$cache_prefix}{$uid}",
            config('flatbbs.cache.ttl'),
            function () use ($uid) {
                return User::getUserById($uid, self::$userInfo)->toArray();
            }
        );

        return json_message(STATUS_OK, '完成', $userinfo);
    }

    public function modify(Request $request)
    {
        $field = $request->post('field', '');
        $value = $request->post('value', '');
        $uid = $request->session()->get('id');

        if (User::modifyUser($uid, $field, $value)) {
            return ok();
        } else {
            return json_message(STATUS_BAD_REQUEST, '失败，信息未更新。');
        }
    }
}
