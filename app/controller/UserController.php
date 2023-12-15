<?php

namespace app\controller;

use app\model\User;
use support\Request;
use Shopwwi\LaravelCache\Cache;

class UserController
{
    public $userBasicFields = [
        'id',
        'email',
        'display_name',
        'username',
        'avatar_uri',
        'introduction'
    ];

    public function info(Request $request)
    {
        $uid = session('id');
        $cache_prefix = config('flatbbs.cache.prefix.userinfo');

        $userinfo = Cache::remember(
            "{$cache_prefix}{$uid}",
            config('flatbbs.cache.ttl'),
            function () use ($uid) {
                return User::getUserById($uid, $this->userBasicFields)->toArray();
            }
        );

        return ok($userinfo);
    }

    public function modify(Request $request)
    {
        $field = $request->post('field', '');
        $value = $request->post('value', '');
        $uid = session('id');

        if (User::modifyUser($uid, $field, $value)) {
            return ok();
        } else {
            return no(STATUS_INTERNAL_ERROR, '失败，信息未更新。');
        }
    }
}
